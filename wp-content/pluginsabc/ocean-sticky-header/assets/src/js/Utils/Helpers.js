export default class Helpers {
    static isTopbarStickyEnabled = () => oceanwpLocalize.hasStickyTopBar == true;

    static isMobileStickyDisabled = () => window.innerWidth <= 960 && oceanwpLocalize.hasStickyMobile != true;

    static slideStickyEffect = () => oceanwpLocalize.stickyEffect == "slide";

    static upStickyEffect = () => oceanwpLocalize.stickyEffect == "up";

    static manualSticky = () => oceanwpLocalize.stickyChoose == "manual";

    static shrinkStickyStyle = () => oceanwpLocalize.stickyStyle == "shrink";

    static getShrinkLogoHeight = () => {
        const shrinkLogoHeight = parseInt(oceanwpLocalize.shrinkLogoHeight);

        return shrinkLogoHeight ? shrinkLogoHeight : 30;
    };
}
