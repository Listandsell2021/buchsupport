import { Ziggy } from '@/storage/data/ziggy';
import route from "ziggy-js";

export default (name = '', option = {}) => {
    return route(name, option, undefined, Ziggy);
}