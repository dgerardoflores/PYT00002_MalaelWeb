import DOM from "./DOM";

export default class Utility {
    static scrollBarTopPosition = () => window.pageYOffset;

    static elemExists = (elem) => {
        return elem && elem !== null;
    };

    static elemVisible = (elem) => !!(elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length);

    static elemOffset = (elem) => {
        if (!elem.getClientRects().length) {
            return { top: 0, left: 0 };
        }

        // Get document-relative position by adding viewport scroll to viewport-relative gBCR
        const rect = elem.getBoundingClientRect();
        const win = elem.ownerDocument.defaultView;
        return {
            top: rect.top + win.pageYOffset,
            left: rect.left + win.pageXOffset,
        };
    };

    static isWPAdminbarVisible = () => this.elemExists(DOM.WPAdminbar) && window.innerWidth > 600;
}
