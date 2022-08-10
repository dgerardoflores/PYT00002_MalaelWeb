export default (() => {
    // Wrap an HTMLElement around each element in an HTMLElement array.
    HTMLElement.prototype.oceanWrap = function (elms) {
        // Convert `elms` to an array, if necessary.
        if (!elms.length) elms = [elms];

        // Loops backwards to prevent having to clone the wrapper on the
        // first element (see `child` below).
        for (let i = elms.length - 1; i >= 0; i--) {
            const child = i > 0 ? this.cloneNode(true) : this;
            const el = elms[i];

            // Cache the current parent and sibling.
            const parent = el.parentNode;
            const sibling = el.nextSibling;

            // Wrap the element (is automatically removed from its current
            // parent).
            child.appendChild(el);

            // If the element had a sibling, insert the wrapper before
            // the sibling to maintain the HTML structure; otherwise, just
            // append it to the parent.
            if (sibling) {
                parent.insertBefore(child, sibling);
            } else {
                parent.appendChild(child);
            }
        }
    };

    // Wrap an HTMLElement around another HTMLElement or an array of them.
    HTMLElement.prototype.oceanWrapAll = function (elms) {
        const el = !!elms && elms.length ? elms[0] : elms;

        // Cache the current parent and sibling of the first element.
        const parent = el.parentNode;
        const sibling = el.nextSibling;

        // Wrap the first element (is automatically removed from its
        // current parent).
        this.appendChild(el);

        // Wrap all other elements (if applicable). Each element is
        // automatically removed from its current parent and from the elms
        // array.
        while (elms.length) {
            this.appendChild(elms[0]);
        }

        // If the first element had a sibling, insert the wrapper before the
        // sibling to maintain the HTML structure; otherwise, just append it
        // to the parent.
        if (sibling) {
            parent.insertBefore(this, sibling);
        } else {
            parent.appendChild(this);
        }
    };
})();
