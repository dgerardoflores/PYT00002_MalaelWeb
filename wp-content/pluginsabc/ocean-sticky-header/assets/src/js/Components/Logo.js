import DOM from "../Utils/DOM";
import Helpers from "../Utils/Helpers";
import Utility from "../Utils/Utility";
import Header from "./Header";

export default class Logo {
    #logo;
    #customLogo;

    constructor() {
        this.#logo = DOM.logo;
        this.#customLogo = DOM.customLogo;
    }

    setMaxHeight = () => {
        // If header style is center
        if (DOM.siteHeader?.classList.contains("center-header")) {
            this.#logo = DOM.middleLogo;
            this.#customLogo = DOM.customMiddleLogo;
        }

        // Return if not shrink style and on some header styles
        if (this.#returnOnSomeHeaderStyles()) {
            return;
        }

        // If mobile logo exists
        if (DOM.logoWrapper?.classList.contains("has-responsive-logo") && Utility.elemVisible(DOM.mobileLogo)) {
            this.#customLogo = DOM.mobileLogo;
        }

        // Get logo position
        let initialLogoHeight;
        if (this.#customLogo) {
            initialLogoHeight = this.#customLogo.offsetHeight;
        }

        let currentPosition = Utility.elemOffset(DOM.headerWrapper).top - Header.getOffset();

        window.addEventListener("scroll", () => {
            // When scrolling
            if (Utility.scrollBarTopPosition() !== 0 && Utility.scrollBarTopPosition() >= currentPosition) {
                Array.from(this.#logo).forEach((elem) => (elem.style.maxHeight = Helpers.getShrinkLogoHeight() + "px"));
            } else if (!!initialLogoHeight) {
                Array.from(this.#logo).forEach((elem) => (elem.style.maxHeight = initialLogoHeight + "px"));
            }
        });
    };

    #returnOnSomeHeaderStyles = () => {
        return (
            !Helpers.shrinkStickyStyle() ||
            !this.#logo ||
            !DOM.headerWrapper ||
            Helpers.isMobileStickyDisabled() ||
            Helpers.manualSticky() ||
            !DOM.siteHeader?.classList.contains("fixed-scroll") ||
            DOM.siteHeader?.classList.contains("top-header") ||
            DOM.siteHeader?.classList.contains("vertical-header") ||
            (DOM.siteHeader?.classList.contains("medium-header") && DOM.bottomHeader.classList.contains("fixed-scroll"))
        );
    };
}
