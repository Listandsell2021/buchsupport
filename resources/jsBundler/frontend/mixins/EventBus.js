import Emitter from 'tiny-emitter/instance';

export default {

    emit(eventName, ...args) {
        Emitter.emit(eventName, ...args)
    },

    on(eventName, callable) {
        Emitter.on(eventName, callable);
    },

    once(eventName, callable) {
        Emitter.once(eventName, callable);
    },

    remove(eventName, callable) {
        Emitter.off(eventName, callable);
    }

}