import Helpers from "./Helpers";

const DOM = {
    WPAdminbar: document.querySelector("#wpadminbar"),
    topbar: document.querySelector("#top-bar-wrap"),
    siteHeader: document.querySelector("#site-header"),
    verticalHeader: document.querySelector("#site-header.vertical-header"),
    bottomHeader: document.querySelector(".bottom-header-wrap"),
    logoWrapper: document.querySelector("#site-logo"),
    logo: document.querySelectorAll("#site-logo img"),
    customLogo: document.querySelector("#site-logo .custom-logo"),
    middleLogo: document.querySelectorAll(".middle-site-logo img"),
    customMiddleLogo: document.querySelector(".middle-site-logo .custom-logo"),
    mobileLogo: document.querySelector("#site-logo .responsive-logo"),
};

DOM.getHeader = () => {
    let headerClass;

    // If manual sticky
    if (Helpers.manualSticky()) {
        headerClass = ".owp-sticky";
    } else {
        headerClass = "#site-header";
    }

    // If top header style
    if (DOM.siteHeader?.classList.contains("top-header")) {
        headerClass = "#site-header .header-top";
    }

    // Medium header style
    if (DOM.siteHeader?.classList.contains("medium-header") && DOM.bottomHeader?.classList.contains("fixed-scroll")) {
        headerClass = ".bottom-header-wrap";
    }

    return document.querySelector(headerClass);
};

DOM.header = DOM.getHeader();

export default DOM;
