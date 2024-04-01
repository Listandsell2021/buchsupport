import PageUrl from "@/storage/data/pageurl";
import AppUtils from "@/libraries/utils/helpers/AppUtils";
import ProductConditions from "@/storage/data/ProductConditions";

export default {

    getCustomerLibraryUrl(customerId) {
        return PageUrl.frontend.libraries(customerId);
    },

    getImageUrl(image) {
        return AppUtils.getApiProductStorageUrl(image);
    },

    getBookUrl(bookId, customerId = '') {
        let queryParams = '';
        if (customerId !== '') {
            queryParams = 'register='+customerId;
        }
        return PageUrl.frontend.books(bookId, queryParams);
    },

    getFirstImageUrl(images) {
        if (images.length > 0) {
            return AppUtils.getApiProductStorageUrl(images[0].image_path);
        }
        return AppUtils.getEmptyImageUrl();
    },

    getFirstImageName(images) {
        if (images.length > 0) {
            return images[0].image_path;
        }
        return '';
    },


    hasProducts(products) {
        return products.length > 0;
    },


    getConditionLabel(conditionNo) {

        for (let productConditionNo in ProductConditions) {
            if (conditionNo == productConditionNo) {
                return ProductConditions[conditionNo];
            }
        }


        return ProductConditions[2];
    },

    hasYoutubeLink(link) {
        if (link != null) {
            return link.length > 0;
        }

        return false;
    },

}
