<?php

namespace App\Http\Controllers;

use App\CommandProcess\Frontend\DownloadProductDetailPdf;
use App\CommandProcess\Frontend\GetCustomerLibrariesData;
use App\DataHolders\Enum\Membership;
use App\DataHolders\Enum\MembershipPackage;
use App\Exports\Frontend\ProductExport;
use App\Http\Requests\DeveloperLoginValidator;
use App\Http\Requests\Frontend\CreateInquiryForBookSellingValidator;
use App\Http\Requests\Frontend\CreateRecordForBookSellingValidator;
use App\Http\Requests\Frontend\CreateRegistrationValidator;
use App\Http\Requests\Frontend\CreateUserBookInquiryRequest;
use App\Http\Requests\Frontend\ForgotPasswordQueryValidator;
use App\Http\Requests\Frontend\GuestContactValidator;
use App\Http\Requests\Frontend\GuestMessageValidator;
use App\Http\Requests\Frontend\MessageFromBookValidator;
use App\Http\Requests\User\CreateSignalBookSellingValidator;
use App\Http\Resources\Frontend\UserPackResource;
use App\Libraries\HelperTraits\JsonResponseHelper;
use App\Libraries\HelperTraits\LibraryHelper;
use App\Models\CallUser;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UserProduct;
use App\Models\Visitor;
use App\Models\VisitorPack;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as IRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Rosamarsky\CommandBus\CommandBus;

class FrontendController extends Controller
{
    use LibraryHelper, JsonResponseHelper;

    private CommandBus $commandBus;
    private int $paginationNo = 10;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Display home page
     *
     * @return Application|Factory|View
     */
    public function getHomePage(Request $request)
    {
        $latestProducts = Product::withDetails()
            ->orderBy('user_products.id', 'desc')
            ->take(8)
            ->get();

        $reviews = Comment::select('comments.*', DB::raw('CONCAT(users.first_name, " ",users.last_name) as user_name'))
            ->join('users', 'comments.user_id', 'users.id')
            ->active()
            ->orderBy('comments.id', 'desc')
            ->get();

        $members = json_decode(File::get(storage_path('data/teams.json')));
        $galleryImages = json_decode(File::get(storage_path('data/home_gallery_images.json')));

        return $this->renderCookieView('frontend.home', compact('latestProducts', 'reviews', 'members', 'galleryImages'));
    }


    /**
     * Get Show Room
     *
     * @return Application|Factory|View
     */
    public function getShowRoomPage(Request $request)
    {
        /*Session::put('is_customer_default_search', Session::get('is_customer_default_search', 1));
        $products = $this->searchProducts([], 40);
        $customers = $this->searchCustomers([], $this->paginationNo);*/
        $products = [];
        $customers = [];

        $minProducts = (UserProduct::select(DB::raw('COUNT(*) as min'))
            ->join('users', 'user_products.user_id', 'users.id')
            ->where('users.is_active', 1)
            ->groupBy(['user_products.user_id'])
            ->orderBy('min', 'asc')
            ->first()
        )->min;

        $maxProducts = (UserProduct::select(DB::raw('COUNT(*) as max'))
            ->join('users', 'user_products.user_id', 'users.id')
            ->where('users.is_active', 1)
            ->groupBy(['user_products.user_id'])
            ->orderBy('max', 'desc')
            ->first()
        )->max;

        return $this->renderCookieView('frontend.showroom', compact('customers', 'products', 'minProducts', 'maxProducts'));
    }


    /**
     * Show Room Filter
     */
    public function getFilteredCustomers(Request $request): JsonResponse
    {
        Session::put('is_customer_default_search', 1);
        $customers = $this->searchCustomers($request->all(), (int) $this->paginationNo);

        //$packageUsers = $this->getPackageUsers();
        $packageUsers = [];

        return $this->apiJsonResponse(1, 'Successfully fetched Customers', [
            'customers' => $customers,
            'users' => $packageUsers,
        ]);
    }


    /**
     * Get Filtered Products
     *
     */
    public function getFilteredProducts(Request $request): JsonResponse
    {
        Session::put('is_customer_default_search', 0);
        $products = $this->searchProducts($request->all(), 40);

        return $this->apiJsonResponse(1, 'Successfully fetched Customers', $products);
    }


    /**
     * Get Customer Libraries
     */
    public function getCustomerLibraries(Request $request, $userid)
    {
        $customer = User::find($userid);

        if (!$customer) {
            abort(404);
        }

        $data = $this->commandBus->execute(new GetCustomerLibrariesData($userid));

        return $this->renderCookieView('frontend.library', array_merge($data, ['customerId' => $userid, 'customer' => $customer]));
    }

    /**
     * Get Book Description
     *
     */
    public function getBookDescription(Request $request, $bookId)
    {
        $registerId = $request->get('register');

        $book = $this->getProductWithDetails()
            ->where('products.id', $bookId)
            ->first();

        if (!$book) {
            abort(404);
        }

        $customers = UserProduct::select('user_products.*', 'users.uid')->where('user_products.product_id', $bookId)
            ->join('users', 'user_products.user_id', 'users.id')
            ->where('users.uid', 'LIKE', '%' . $request->get('user-id') . '%')
            ->where('user_products.user_id', '!=', $book->user_id)
            ->where('user_products.status', 1)
            ->where('user_products.is_hidden', 0)
            ->paginate(5);

        return $this->renderCookieView('frontend.book', compact('book', 'customers', 'registerId'));
    }


    /**
     * Search By Customer ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchByCustomerId(Request $request): JsonResponse
    {
        $customer = User::find($request->get('user_id'));

        if (!$customer) {
            return $this->apiJsonResponse(1, 'Could not found customer', ['is_available' => 0]);
        }

        return $this->apiJsonResponse(1, 'Customer found successfully', ['is_available' => 1]);
    }



    /**
     * GET DEVELOPER LOGIN PAGE
     */
    public function getDeveloperLogin()
    {
        return view('developer_login');
    }


    /**
     * GET DEVELOPER LOGIN PAGE
     */
    public function setDeveloperLogin(DeveloperLoginValidator $request): RedirectResponse
    {
        $name = $request->get('name');
        $password = $request->get('password');

        if ($name === 'root' && $password === 'newpassword') {
            session()->put('developer_ip_address', $request->ip());
            flash('You are logged in as developer')->success()->important();
            return redirect()->route('frontend.home');
        }

        flash('Invalid user or password')->error()->important();
        return redirect()->back();
    }



    /**
     * Data Protection Page
     */
    public function getDataProtectionPage()
    {
        return $this->renderCookieView('frontend.pages.data_protection');
    }

    /**
     * Get Imprint Page
     */
    public function getImprintPage()
    {
        return $this->renderCookieView('frontend.pages.imprint');
    }

    /**
     * Get Contact Page
     *
     * @return Application|Factory|Response|View
     */
    public function getContactPage()
    {
        return $this->renderCookieView('frontend.pages.contact');
    }


    /**
     * Get Team Page
     *
     * @return Application|Factory|Response|View
     */
    public function getTeamPage()
    {
        return $this->renderCookieView('frontend.pages.team');
    }


    /**
     * Send User Message
     */
    public function sendGuestMessageToUser(GuestMessageValidator $request): RedirectResponse
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $message = $request->get('message');

        CallUser::create([
            'user_id' => $request->get('user_id'),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $email,
            'note' => $message,
            'type' => 'help',
        ]);

        return redirect()->back()->with('success', 'Nachricht erfolgreich senden');
    }


    /**
     * Send User Message
     */
    public function sendMessageFromBook(MessageFromBookValidator $request): RedirectResponse
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = $request->get('price');
        $userFromBook = User::findOrFail($request->get('user_id'));
        $product = Product::find($request->get('book_id'));

        $userDetail = '';
        if ($userFromBook) {
            $userDetail = " von $userFromBook->first_name $userFromBook->last_name ($userFromBook->id)";
        }

        $note = $first_name." ".$last_name. " interessiert sich für das Werk ".$product->title.$userDetail;

        CallUser::create([
            'note' => $note,
            'type' => 'buy_product',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            'price' => $price,
        ]);

        return redirect()->back()->with('success', 'Nachricht erfolgreich senden');
    }


    /**
     * Send User Message
     */
    public function registerContactForm(GuestContactValidator $request)
    {
        $this->createUserCall($request);

        $isContactPage = (bool) (strpos(url()->previous(), 'rueckruf') !== false);

        $previousUrl = url()->previous().(!$isContactPage ? '#main-footer' : '');

        return redirect()->to($previousUrl)->with('query_success', 'Rückruf wurde hinterlegt </br> Wir rufen sie schnellstmöglich zurück');
    }


    public function createUserCall(Request $request)
    {
        $userId = trimUserId($request->get('user_id'));
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $phone = $request->get('callback_number');
        $note = $request->get('callback_note');

        $fields = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'note' => $note,
            'type' => 'help',
        ];

        if (!empty($userId) || $userId != '') {
            $fields['user_id'] = getUserIdByUid($userId);
        }

        return CallUser::create($fields);
    }


    public function downloadProductCsv(Request $request)
    {
        if ($request->get('key') == '9585285517364942_password1') {
            return Excel::download(new ProductExport(), 'products.csv', \Maatwebsite\Excel\Excel::CSV);
        }
        abort(404);
    }


    /**
     * Forgot Password Query
     *
     * @param ForgotPasswordQueryValidator $request
     * @return RedirectResponse
     */
    public function forgotPasswordQuery(ForgotPasswordQueryValidator $request): RedirectResponse
    {
        $this->storeForgotPasswordMessage($request);

        flash(trans('frontend.forgot_password_queried'))->success()->important();

        $isContactPage = (bool) (strpos(url()->previous(), 'rueckruf') !== false);

        $previousUrl = url()->previous().(!$isContactPage ? '#main-footer' : '');

        return redirect()->to($previousUrl);
    }


    /**
     * Forgot Password Request
     *
     * @param ForgotPasswordQueryValidator $request
     * @return JsonResponse
     */
    public function requestForgotPassword(ForgotPasswordQueryValidator $request): JsonResponse
    {
        $this->storeForgotPasswordMessage($request);

        return $this->apiJsonResponse(1, 'Passwort vergessen wurde angefordert');
    }


    /**
     * Send Forgot Password Message
     *
     * @param $request
     */
    public function storeForgotPasswordMessage($request)
    {
        $note = $request->get('user_id').' hat das Passwort vergessen und aufgefordert, das Passwort zu ändern';

        CallUser::create([
            'note' => $note,
            'user_id' => getUserIdByUid($request->get('user_id')),
            'first_name' => $request->get('username'),
            'phone' => $request->get('phone_no'),
            'type' => 'help',
        ]);
    }


    /**
     * Create Signal For Guest book selling
     *
     * @param CreateRecordForBookSellingValidator $request
     * @return Response
     */
    public function createSignalForGuestBookSelling(CreateRecordForBookSellingValidator $request): Response
    {
        $this->createSignalOnProduct($request);

        return response(['success' => true], 200);
    }


    /**
     * Create Signal on Product
     *
     * @param Request $request
     * @return void
     */
    public function createSignalOnProduct(Request $request): void
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = $request->get('price');
        $bookUser = User::find($request->get('userId'));
        $product = Product::find($request->get('productId'));
        $title = $product->title;

        $note = "$firstName $lastName interessiert sich für das Werk \"$title\" von $bookUser->first_name $bookUser->last_name ($bookUser->id)";

        CallUser::create([
            'note' => $note,
            'type' => 'buy_product',
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $email,
            'price' => $price,
        ]);
    }


    /**
     * Create Inquiry for book selling
     *
     * @param CreateInquiryForBookSellingValidator $request
     * @return Response
     */
    public function createInquiryForBookSelling(CreateInquiryForBookSellingValidator $request): Response
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = $request->get('price');
        $product = Product::find($request->get('productId'));

        $note = $first_name." ".$last_name. " interessiert sich für das Werk ".$product->title;

        CallUser::create([
            'note' => $note,
            'type' => 'buy_product',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            'price' => $price,
        ]);

        return response(['success' => true], 200);
    }



    public function downloadUserProductDetail($userId) {
        return $this->commandBus->execute(new DownloadProductDetailPdf((int) $userId));
    }

    /**
     * Render Cookie View
     *
     * @param $viewPath
     * @param array $data
     * @return Application|Factory|Response|View
     */
    public function renderCookieView($viewPath, array $data = [])
    {
        if (request()->hasCookie('scam_popup')) {
            return view($viewPath, $data);
        }

        return response()->view($viewPath, $data)
            ->withCookie(cookie('scam_popup', '123456', 120));
    }


}
