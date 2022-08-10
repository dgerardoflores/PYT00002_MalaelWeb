import "./Utils/DOMMethods";
import Utility from "./Utils/Utility";
import Topbar from "./Components/Topbar";
import Header from "./Components/Header";
import Logo from "./Components/Logo";

class OW_StickyHeader {
    #scrollBarlatestTopPosition;

    constructor() {
        this.topbar = new Topbar();
        this.header = new Header();
        this.logo = new Logo();
    }

    start = () => {
        this.#scrollBarlatestTopPosition = Utility.scrollBarTopPosition();

        this.#setupEventListeners();
    };

    #setupEventListeners = () => {
        window.addEventListener("load", this.#onWindowLoad);
        window.addEventListener("scroll", this.#onWindowScroll);
        window.addEventListener("resize", this.#onWindowResize);
        window.addEventListener("orientationchange", this.#onWindowResize);
    };

    #onWindowLoad = () => {
        this.topbar.createStickyWrapper();
        this.header.createStickyWrapper();
        this.header.addVerticalHeaderSticky();
        this.logo.setMaxHeight();
    };

    #onWindowScroll = () => {
        if (Utility.scrollBarTopPosition() != this.#scrollBarlatestTopPosition) {
            this.topbar.sticky();
            this.header.sticky();
            this.header.stickyEffects();
            this.header.addVerticalHeaderSticky();

            this.#scrollBarlatestTopPosition = Utility.scrollBarTopPosition();
        }
    };

    #onWindowResize = () => {
        this.topbar.updateSticky();
        this.header.updateSticky();
    };
}

("use strict");

const stickyHeader = new OW_StickyHeader();
stickyHeader.start();
