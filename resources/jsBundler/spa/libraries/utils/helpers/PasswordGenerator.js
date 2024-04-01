import { randomPassword  } from 'secure-random-password';
import { lower, upper, digits } from 'secure-random-password/lib/character-sets';

export default {

    generate(length = 8) {
        return randomPassword({
            length: length,
            characters: [lower, upper, digits]
        });
    },

    getString(length) {
        let result           = '';
        let characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }

}
