import { h } from 'vue'

export default {

    open() {
        let body = document.getElementsByTagName('body');
        body[0].classList.add('modal-open');

        this.addModalBackdropElement();
    },

    close() {
        let body = document.getElementsByTagName('body');
        body[0].classList.remove('modal-open');

        this.removeModalBackdropElement();
    },

    addModalBackdropElement() {
        let body = document.getElementsByTagName('body');
        const modalBackdrop = document.createElement('div')
        modalBackdrop.className = 'modal-backdrop fade show';
        body[0].appendChild(modalBackdrop)
    },

    removeModalBackdropElement() {
        const modalBackdrop = document.getElementsByClassName('modal-backdrop');
        while(modalBackdrop.length > 0){
            modalBackdrop[0].parentNode.removeChild(modalBackdrop[0]);
        }
    }

}

