<?php

namespace App\CommandProcess\Customer\Profile;

use App\Helpers\Config\BuchConfig;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UploadProfileImageHandler implements Handler
{

    public function handle(Command $command)
    {
        $this->removePreviousImage($command->userId);

        $imageName = $command->image->getClientOriginalName();
        $imageFolderPath = BuchConfig::getUserProfileRelativePath($command->userId);

        Storage::disk('public')->putFileAs($imageFolderPath, $command->image, $imageName);
        User::where('id', $command->userId)->update(['image_path' => $imageName]);
    }



    /**
     * Remove Previous Path
     *
     * @param $userId
     * @return void
     */
    private function removePreviousImage($userId): void
    {
        $user = User::find($userId);

        if (!$user->image_path) {
            return;
        }

        $imagePath = BuchConfig::getUserProfileRelativePath($userId.DIRECTORY_SEPARATOR.$user->image_path);

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

    }
}
