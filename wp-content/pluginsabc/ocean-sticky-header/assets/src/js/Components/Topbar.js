import DOM from "../Utils/DOM";
import Utility from "../Utils/Utility";
import Helpers from "../Utils/Helpers";

export default class Topbar {
    sticky = () => {
        if (this.#noSticky()) {
            return;
        }

        let currentPosition = 0;

        if (!!DOM.topbarWrapper) {
            currentPosition = Utility.elemOffset(DOM.topbarWrapper).top - this.getOffset();
        }

        // When scrolling
        if (Utility.scrollBarTopPosition() !== 0 && Utility.scrollBarTopPosition() >= currentPosition) {
            DOM.topbarWrapper?.classList.add("is-sticky");

            DOM.topbar.style.top = this.getOffset() + "px";
            DOM.topbar.style.width = DOM.topbarWrapper?.offsetWidth + "px";
        } else {
            DOM.topbarWrapper?.classList.remove("is-sticky");

            DOM.topbar.style.top = "";
            DOM.topbar.style.width = "";
        }
    };

    updateSticky = () => {
        if (!DOM.topbar || !DOM.topbarWrapper || !Helpers.isTopbarStickyEnabled()) {
            return;
        }

        if (!DOM.topbarWrapper.classList.contains("is-sticky")) {
            DOM.topbarWrapper.style.height = DOM.topbar.offsetHeight + "px";
        }

        if (Utility.scrollBarTopPosition() !== 0) {
            DOM.topbar.style.top = this.getOffset() + "px";
            DOM.topbar.style.width = DOM.topbarWrapper?.offsetWidth + "px";
        }
    };

    createStickyWrapper = () => {
        if (!Helpers.isTopbarStickyEnabled()) {
            return;
        }

        // Create topbar sticky wrapper element
        DOM.topbarWrapper = document.createElement("div");
        DOM.topbarWrapper.setAttribute("id", "top-bar-sticky-wrapper");
        DOM.topbarWrapper.setAttribute("class", "oceanwp-sticky-top-bar-holder");

        // Wrap topbar sticky wrapper around topbar
        if (!!DOM.topbar) {
            DOM.topbarWrapper?.oceanWrapAll(DOM.topbar);

            // Set topbar sticky wrapper height
            DOM.topbarWrapper.style.height = DOM.topbar.offsetHeight + "px";
        }
    };

    getOffset = () => {
        let offset = 0;

        // Add WP Adminbar offset
        if (Utility.isWPAdminbarVisible()) {
            offset = offset + DOM.WPAdminbar?.offsetHeight;
        }

        return offset;
    };

    #noSticky = () => !Helpers.isTopbarStickyEnabled() || !DOM.topbar || Helpers.isMobileStickyDisabled();
}
