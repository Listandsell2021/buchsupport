export default {

    methods: {

        getCustomerLibraryUrl(config, customerId) {
            return config.customerLibraryUrl + customerId;
        },

        getImageUrl(config, image) {
            return config.storageUrl + image;
        },

        getBookUrl(config, bookId, customerId = '') {
            let queryParams = '';
            if (customerId !== '') {
                queryParams = '?register='+customerId;
            }
            return config.bookUrl + bookId + queryParams;
        },

        getFirstImageUrl(config, images) {
            if (images.length > 0) {
                return config.storageUrl + images[0].image_path;
            }
            return config.emptyImageUrl;
        },

        getFirstImageName(images) {
            if (images.length > 0) {
                return images[0].image_path;
            }
            return '';
        },

        isProductGreaterThanLimit(config, products) {
            return products.length > config.sliderItemLimit;
        },

        doesCustomerHaveProducts(products) {
            return products.length > 0;
        },

        getCustomerMembership(membership) {
            if (typeof membership === 'string' || membership instanceof String) {
                let result = '';
                switch (membership) {
                    case "Bronze":
                        result = "Schwarz";
                        break;
                    case "Silver":
                        result = "Silber";
                        break;
                    case "Gold":
                        result = "Gold";
                        break;
                    case ("Gold Plus"):
                        result = "Gold +";
                        break;
                    case ("bronze"):
                        result = "Schwarz";
                        break;
                    case ("silver"):
                        result = "Silber";
                        break;
                    case ("gold"):
                        result = "Gold";
                        break;
                    case ("gold_plus"):
                        result = "Gold +";
                        break;
                    default:
                        result = '';
                }

                return result;
            }
            return '';
        },

        getConditionLabel(config, conditionNo) {
            let conditionLabel = '';
            for (let index in config.product_conditions) {
                if (conditionNo == config.product_conditions[index].value) {
                    conditionLabel = config.product_conditions[index].label;
                }
            }

            if (conditionLabel !== '') {
                return conditionLabel;
            }

            return config.product_condition_default;
        },

    }

}
