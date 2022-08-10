(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.registerWidget = exports.isElement = exports.getSiblings = exports.visible = exports.offset = exports.fadeToggle = exports.fadeOut = exports.fadeIn = exports.slideToggle = exports.slideUp = exports.slideDown = void 0;

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var slideDown = function slideDown(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  var display = window.getComputedStyle(element).display;

  if (display === "none") {
    display = "block";
  }

  element.style.transitionProperty = "height";
  element.style.transitionDuration = "".concat(duration, "ms");
  element.style.opacity = 0;
  element.style.display = display;
  var height = element.offsetHeight;
  element.style.height = 0;
  element.style.opacity = 1;
  element.style.overflow = "hidden";
  setTimeout(function () {
    element.style.height = "".concat(height, "px");
  }, 5);
  window.setTimeout(function () {
    element.style.removeProperty("height");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
    element.style.removeProperty("opacity");
  }, duration + 50);
};

exports.slideDown = slideDown;

var slideUp = function slideUp(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  element.style.boxSizing = "border-box";
  element.style.transitionProperty = "height, margin";
  element.style.transitionDuration = "".concat(duration, "ms");
  element.style.height = "".concat(element.offsetHeight, "px");
  element.style.marginTop = 0;
  element.style.marginBottom = 0;
  element.style.overflow = "hidden";
  setTimeout(function () {
    element.style.height = 0;
  }, 5);
  window.setTimeout(function () {
    element.style.display = "none";
    element.style.removeProperty("height");
    element.style.removeProperty("margin-top");
    element.style.removeProperty("margin-bottom");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
  }, duration + 50);
};

exports.slideUp = slideUp;

var slideToggle = function slideToggle(element, duration) {
  window.getComputedStyle(element).display === "none" ? slideDown(element, duration) : slideUp(element, duration);
};

exports.slideToggle = slideToggle;

var fadeIn = function fadeIn(element) {
  var _options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  var options = {
    duration: 300,
    display: null,
    opacity: 1,
    callback: null
  };
  Object.assign(options, _options);
  element.style.opacity = 0;
  element.style.display = options.display || "block";
  setTimeout(function () {
    element.style.transition = "".concat(options.duration, "ms opacity ease");
    element.style.opacity = options.opacity;
  }, 5);
  setTimeout(function () {
    element.style.removeProperty("transition");
    !!options.callback && options.callback();
  }, options.duration + 50);
};

exports.fadeIn = fadeIn;

var fadeOut = function fadeOut(element) {
  var _options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  var options = {
    duration: 300,
    display: null,
    opacity: 0,
    callback: null
  };
  Object.assign(options, _options);
  element.style.opacity = 1;
  element.style.display = options.display || "block";
  setTimeout(function () {
    element.style.transition = "".concat(options.duration, "ms opacity ease");
    element.style.opacity = options.opacity;
  }, 5);
  setTimeout(function () {
    element.style.display = "none";
    element.style.removeProperty("transition");
    !!options.callback && options.callback();
  }, options.duration + 50);
};

exports.fadeOut = fadeOut;

var fadeToggle = function fadeToggle(element, options) {
  window.getComputedStyle(element).display === "none" ? fadeIn(element, options) : fadeOut(element, options);
};

exports.fadeToggle = fadeToggle;

var offset = function offset(element) {
  if (!element.getClientRects().length) {
    return {
      top: 0,
      left: 0
    };
  } // Get document-relative position by adding viewport scroll to viewport-relative gBCR


  var rect = element.getBoundingClientRect();
  var win = element.ownerDocument.defaultView;
  return {
    top: rect.top + win.pageYOffset,
    left: rect.left + win.pageXOffset
  };
};

exports.offset = offset;

var visible = function visible(element) {
  if (!element) {
    return false;
  }

  return !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
};

exports.visible = visible;

var getSiblings = function getSiblings(e) {
  // for collecting siblings
  var siblings = []; // if no parent, return no sibling

  if (!e.parentNode) {
    return siblings;
  } // first child of the parent node


  var sibling = e.parentNode.firstChild; // collecting siblings

  while (sibling) {
    if (sibling.nodeType === 1 && sibling !== e) {
      siblings.push(sibling);
    }

    sibling = sibling.nextSibling;
  }

  return siblings;
}; // Returns true if it is a DOM element


exports.getSiblings = getSiblings;

var isElement = function isElement(o) {
  return (typeof HTMLElement === "undefined" ? "undefined" : _typeof(HTMLElement)) === "object" ? o instanceof HTMLElement // DOM2
  : o && _typeof(o) === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string";
};

exports.isElement = isElement;

var registerWidget = function registerWidget(className, widgetName) {
  var skin = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "default";

  if (!(className || widgetName)) {
    return;
  }
  /**
   * Because Elementor plugin uses jQuery custom event,
   * We also have to use jQuery to use this event
   */


  jQuery(window).on("elementor/frontend/init", function () {
    var addHandler = function addHandler($element) {
      elementorFrontend.elementsHandler.addHandler(className, {
        $element: $element
      });
    };

    elementorFrontend.hooks.addAction("frontend/element_ready/".concat(widgetName, ".").concat(skin), addHandler);
  });
};

exports.registerWidget = registerWidget;

},{}],2:[function(require,module,exports){
"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var _utils = require("../lib/utils");

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _get(target, property, receiver) { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(receiver); } return desc.value; }; } return _get(target, property, receiver || target); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var OEW_GoogleMap = /*#__PURE__*/function (_elementorModules$fro) {
  _inherits(OEW_GoogleMap, _elementorModules$fro);

  var _super = _createSuper(OEW_GoogleMap);

  function OEW_GoogleMap() {
    var _this;

    _classCallCheck(this, OEW_GoogleMap);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _super.call.apply(_super, [this].concat(args));

    _defineProperty(_assertThisInitialized(_this), "googleMap", void 0);

    _defineProperty(_assertThisInitialized(_this), "infoWindow", void 0);

    return _this;
  }

  _createClass(OEW_GoogleMap, [{
    key: "getDefaultSettings",
    value: function getDefaultSettings() {
      return {
        selectors: {
          googleMap: ".oew-google-map"
        },
        addresses: [],
        zoom: 4,
        mapType: "roadmap",
        markerAnimation: null,
        streetViewControl: false,
        mapTypeControl: false,
        zoomControl: false,
        fullscreenControl: false,
        scrollToZoom: "none",
        styles: []
      };
    }
  }, {
    key: "getDefaultElements",
    value: function getDefaultElements() {
      var element = this.$element.get(0);
      var selectors = this.getSettings("selectors");
      return {
        googleMap: element.querySelector(selectors.googleMap)
      };
    }
  }, {
    key: "onInit",
    value: function onInit() {
      var _get2;

      for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
        args[_key2] = arguments[_key2];
      }

      (_get2 = _get(_getPrototypeOf(OEW_GoogleMap.prototype), "onInit", this)).call.apply(_get2, [this].concat(args));

      this.setUserSettings();
      this.initGoogleMap();
    }
  }, {
    key: "initGoogleMap",
    value: function initGoogleMap() {
      var googleMapOptions = this.getGoogleMapOptions();
      this.googleMap = new google.maps.Map(this.elements.googleMap, googleMapOptions);
      this.setAddresses();
    }
  }, {
    key: "getGoogleMapOptions",
    value: function getGoogleMapOptions() {
      var settings = this.getSettings();
      var latitude = settings.addresses[0][0];
      var longitude = settings.addresses[0][1];
      return {
        center: new google.maps.LatLng(latitude, longitude),
        zoom: settings.zoom,
        mapTypeId: settings.mapType,
        streetViewControl: settings.streetViewControl,
        mapTypeControl: settings.mapTypeControl,
        zoomControl: settings.zoomControl,
        fullscreenControl: settings.fullscreenControl,
        gestureHandling: settings.scrollToZoom,
        styles: settings.styles
      };
    }
  }, {
    key: "setAddresses",
    value: function setAddresses() {
      var _this2 = this;

      var settings = this.getSettings();
      settings.addresses.forEach(function (address) {
        var addressLatitude = address[0];
        var addressLongitude = address[1];
        var addressTitle = address[3];

        if (!!addressLatitude && !!addressLongitude) {
          var markerIconType = address[5];
          var markerIconURL = address[6];
          var markerIconSize = address[7]; // Set address marker

          var marker = _this2.createMarker(addressLatitude, addressLongitude, addressTitle, markerIconType, markerIconURL, markerIconSize);

          var enableInfoWindow = address[2];
          var enableInfoWindowOnDocumentLoad = address[8];
          var infoWindowDescription = address[4];

          if (!!enableInfoWindow && addressTitle) {
            var infoWindow = _this2.createInfoWindow(marker, addressTitle, infoWindowDescription);

            if (!!enableInfoWindowOnDocumentLoad) {
              infoWindow.open(_this2.googleMap, marker);
            }

            google.maps.event.addListener(marker, "click", function () {
              infoWindow.open(_this2.googleMap, marker);
            });
            google.maps.event.addListener(_this2.googleMap, "click", function () {
              infoWindow.close();
            });
          }
        }
      });
    }
  }, {
    key: "createMarker",
    value: function createMarker(addressLatitude, addressLongitude, addressTitle, markerIconType, markerIconURL, markerIconSize) {
      var markerAnimation = this.getSettings("markerAnimation");
      var animation = null;

      switch (markerAnimation) {
        case "drop":
          animation = google.maps.Animation.DROP;
          break;

        case "bounce":
          animation = google.maps.Animation.BOUNCE;
          break;
      }

      return new google.maps.Marker({
        position: new google.maps.LatLng(addressLatitude, addressLongitude),
        map: this.googleMap,
        title: addressTitle,
        animation: animation,
        icon: markerIconType === "custom" ? {
          url: markerIconURL,
          scaledSize: new google.maps.Size(markerIconSize, markerIconSize),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(0, 0)
        } : ""
      });
    }
  }, {
    key: "createInfoWindow",
    value: function createInfoWindow(marker, addressTitle, infoWindowDescription) {
      var infoWindowOptinos = {};
      var datasetMaxWidth = this.elements.googleMap.dataset.iwMaxWidth;
      infoWindowOptinos.content = "\n        <div class=\"oew-infowindow-content\">\n            <div class=\"oew-infowindow-title\">".concat(addressTitle, "</div>\n            ").concat(!!infoWindowDescription ? "<div class=\"oew-infowindow-description\">".concat(infoWindowDescription, "</div>") : "", "\n        </div>");

      if (!!datasetMaxWidth) {
        infoWindowOptinos.maxWidth = datasetMaxWidth;
      }

      return new google.maps.InfoWindow(infoWindowOptinos);
    }
  }, {
    key: "setUserSettings",
    value: function setUserSettings() {
      var settings = this.getSettings();
      var datasetSettings = this.elements.googleMap.dataset;
      var elementSettings = this.getElementSettings();
      var addresses = !!datasetSettings.locations ? JSON.parse(datasetSettings.locations) : settings.addresses;
      var zoom = !Number.isNaN(Number(datasetSettings.zoom)) ? Number(datasetSettings.zoom) : settings.zoom;
      var mapType = !!elementSettings.map_type ? elementSettings.map_type : settings.mapType;
      var zoomControl = !!elementSettings.zoom_control ? elementSettings.zoom_control : settings.zoomControl;
      var styles = !!datasetSettings.customStyle ? JSON.parse(datasetSettings.customStyle) : settings.styles;
      var markerAnimation = !!elementSettings.marker_animation ? elementSettings.marker_animation : settings.markerAnimation;
      var streetViewControl = !!elementSettings.map_option_streetview ? elementSettings.map_option_streetview : settings.streetViewControl;
      var mapTypeControl = !!elementSettings.map_type_control ? elementSettings.map_type_control : settings.mapTypeControl;
      var fullscreenControl = !!elementSettings.fullscreen_control ? elementSettings.fullscreen_control : settings.fullscreenControl;
      var scrollToZoom = !!elementSettings.map_scroll_zoom ? elementSettings.map_scroll_zoom : settings.scrollToZoom;
      this.setSettings({
        addresses: addresses,
        zoom: zoom,
        mapType: mapType,
        markerAnimation: markerAnimation,
        streetViewControl: streetViewControl,
        mapTypeControl: mapTypeControl,
        zoomControl: zoomControl,
        fullscreenControl: fullscreenControl,
        scrollToZoom: scrollToZoom,
        styles: styles
      });
    }
  }]);

  return OEW_GoogleMap;
}(elementorModules.frontend.handlers.Base);

(0, _utils.registerWidget)(OEW_GoogleMap, "oew-google-map");

},{"../lib/utils":1}]},{},[2])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJhc3NldHMvc3JjL2pzL2xpYi91dGlscy5qcyIsImFzc2V0cy9zcmMvanMvd2lkZ2V0cy9nb29nbGUtbWFwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7Ozs7O0FDQU8sSUFBTSxTQUFTLEdBQUcsU0FBWixTQUFZLENBQUMsT0FBRCxFQUE2QjtBQUFBLE1BQW5CLFFBQW1CLHVFQUFSLEdBQVE7QUFDbEQsTUFBSSxPQUFPLEdBQUcsTUFBTSxDQUFDLGdCQUFQLENBQXdCLE9BQXhCLEVBQWlDLE9BQS9DOztBQUVBLE1BQUksT0FBTyxLQUFLLE1BQWhCLEVBQXdCO0FBQ3BCLElBQUEsT0FBTyxHQUFHLE9BQVY7QUFDSDs7QUFFRCxFQUFBLE9BQU8sQ0FBQyxLQUFSLENBQWMsa0JBQWQsR0FBbUMsUUFBbkM7QUFDQSxFQUFBLE9BQU8sQ0FBQyxLQUFSLENBQWMsa0JBQWQsYUFBc0MsUUFBdEM7QUFFQSxFQUFBLE9BQU8sQ0FBQyxLQUFSLENBQWMsT0FBZCxHQUF3QixDQUF4QjtBQUNBLEVBQUEsT0FBTyxDQUFDLEtBQVIsQ0FBYyxPQUFkLEdBQXdCLE9BQXhCO0FBQ0EsTUFBSSxNQUFNLEdBQUcsT0FBTyxDQUFDLFlBQXJCO0FBRUEsRUFBQSxPQUFPLENBQUMsS0FBUixDQUFjLE1BQWQsR0FBdUIsQ0FBdkI7QUFDQSxFQUFBLE9BQU8sQ0FBQyxLQUFSLENBQWMsT0FBZCxHQUF3QixDQUF4QjtBQUNBLEVBQUEsT0FBTyxDQUFDLEtBQVIsQ0FBYyxRQUFkLEdBQXlCLFFBQXpCO0FBRUEsRUFBQSxVQUFVLENBQUMsWUFBTTtBQUNiLElBQUEsT0FBTyxDQUFDLEtBQVIsQ0FBYyxNQUFkLGFBQTBCLE1BQTFCO0FBQ0gsR0FGUyxFQUVQLENBRk8sQ0FBVjtBQUlBLEVBQUEsTUFBTSxDQUFDLFVBQVAsQ0FBa0IsWUFBTTtBQUNwQixJQUFBLE9BQU8sQ0FBQyxLQUFSLENBQWMs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QXNFLFFBQVEsQ0FBQyxZQUFwRztBQUVBLFdBQUssV0FBTCxDQUFpQjtBQUNiLFFBQUEsU0FBUyxFQUFFLFNBREU7QUFFYixRQUFBLElBQUksRUFBRSxJQUZPO0FBR2IsUUFBQSxPQUFPLEVBQUUsT0FISTtBQUliLFFBQUEsZUFBZSxFQUFFLGVBSko7QUFLYixRQUFBLGlCQUFpQixFQUFFLGlCQUxOO0FBTWIsUUFBQSxjQUFjLEVBQUUsY0FOSDtBQU9iLFFBQUEsV0FBVyxFQUFFLFdBUEE7QUFRYixRQUFBLGlCQUFpQixFQUFFLGlCQVJOO0FBU2IsUUFBQSxZQUFZLEVBQUUsWUFURDtBQVViLFFBQUEsTUFBTSxFQUFFO0FBVkssT0FBakI7QUFZSDs7OztFQXRNdUIsZ0JBQWdCLENBQUMsUUFBakIsQ0FBMEIsUUFBMUIsQ0FBbUMsSTs7QUF5TS9ELDJCQUFlLGFBQWYsRUFBOEIsZ0JBQTlCIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oKXtmdW5jdGlvbiByKGUsbix0KXtmdW5jdGlvbiBvKGksZil7aWYoIW5baV0pe2lmKCFlW2ldKXt2YXIgYz1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlO2lmKCFmJiZjKXJldHVybiBjKGksITApO2lmKHUpcmV0dXJuIHUoaSwhMCk7dmFyIGE9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitpK1wiJ1wiKTt0aHJvdyBhLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsYX12YXIgcD1uW2ldPXtleHBvcnRzOnt9fTtlW2ldWzBdLmNhbGwocC5leHBvcnRzLGZ1bmN0aW9uKHIpe3ZhciBuPWVbaV1bMV1bcl07cmV0dXJuIG8obnx8cil9LHAscC5leHBvcnRzLHIsZSxuLHQpfXJldHVybiBuW2ldLmV4cG9ydHN9Zm9yKHZhciB1PVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmUsaT0wO2k8dC5sZW5ndGg7aSsrKW8odFtpXSk7cmV0dXJuIG99cmV0dXJuIHJ9KSgpIiwiZXhwb3J0IGNvbnN0IHNsaWRlRG93biA9IChlbGVtZW50LCBkdXJhdGlvbiA9IDMwMCkgPT4ge1xuICAgIGxldCBkaXNwbGF5ID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkuZGlzcGxheTtcblxuICAgIGlmIChkaXNwbGF5ID09PSBcIm5vbmVcIikge1xuICAgICAgICBkaXNwbGF5ID0gXCJibG9ja1wiO1xuICAgIH1cblxuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJoZWlnaHRcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9ufW1zYDtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gZGlzcGxheTtcbiAgICBsZXQgaGVpZ2h0ID0gZWxlbWVudC5vZmZzZXRIZWlnaHQ7XG5cbiAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gMTtcbiAgICBlbGVtZW50LnN0eWxlLm92ZXJmbG93ID0gXCJoaWRkZW5cIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IGAke2hlaWdodH1weGA7XG4gICAgfSwgNSk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJvdmVyZmxvd1wiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tZHVyYXRpb25cIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLXByb3BlcnR5XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwib3BhY2l0eVwiKTtcbiAgICB9LCBkdXJhdGlvbiArIDUwKTtcbn07XG5cbmV4cG9ydCBjb25zdCBzbGlkZVVwID0gKGVsZW1lbnQsIGR1cmF0aW9uID0gMzAwKSA9PiB7XG4gICAgZWxlbWVudC5zdHlsZS5ib3hTaXppbmcgPSBcImJvcmRlci1ib3hcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25Qcm9wZXJ0eSA9IFwiaGVpZ2h0LCBtYXJnaW5cIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9ufW1zYDtcbiAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IGAke2VsZW1lbnQub2Zmc2V0SGVpZ2h0fXB4YDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpblRvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Cb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gMDtcbiAgICB9LCA1KTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gXCJub25lXCI7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJtYXJnaW4tdG9wXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwibWFyZ2luLWJvdHRvbVwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm92ZXJmbG93XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1kdXJhdGlvblwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tcHJvcGVydHlcIik7XG4gICAgfSwgZHVyYXRpb24gKyA1MCk7XG59O1xuXG5leHBvcnQgY29uc3Qgc2xpZGVUb2dnbGUgPSAoZWxlbWVudCwgZHVyYXRpb24pID0+IHtcbiAgICB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5kaXNwbGF5ID09PSBcIm5vbmVcIiA/IHNsaWRlRG93bihlbGVtZW50LCBkdXJhdGlvbikgOiBzbGlkZVVwKGVsZW1lbnQsIGR1cmF0aW9uKTtcbn07XG5cbmV4cG9ydCBjb25zdCBmYWRlSW4gPSAoZWxlbWVudCwgX29wdGlvbnMgPSB7fSkgPT4ge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7XG4gICAgICAgIGR1cmF0aW9uOiAzMDAsXG4gICAgICAgIGRpc3BsYXk6IG51bGwsXG4gICAgICAgIG9wYWNpdHk6IDEsXG4gICAgICAgIGNhbGxiYWNrOiBudWxsLFxuICAgIH07XG5cbiAgICBPYmplY3QuYXNzaWduKG9wdGlvbnMsIF9vcHRpb25zKTtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gb3B0aW9ucy5kaXNwbGF5IHx8IFwiYmxvY2tcIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb24gPSBgJHtvcHRpb25zLmR1cmF0aW9ufW1zIG9wYWNpdHkgZWFzZWA7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IG9wdGlvbnMub3BhY2l0eTtcbiAgICB9LCA1KTtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvblwiKTtcbiAgICAgICAgISFvcHRpb25zLmNhbGxiYWNrICYmIG9wdGlvbnMuY2FsbGJhY2soKTtcbiAgICB9LCBvcHRpb25zLmR1cmF0aW9uICsgNTApO1xufTtcblxuZXhwb3J0IGNvbnN0IGZhZGVPdXQgPSAoZWxlbWVudCwgX29wdGlvbnMgPSB7fSkgPT4ge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7XG4gICAgICAgIGR1cmF0aW9uOiAzMDAsXG4gICAgICAgIGRpc3BsYXk6IG51bGwsXG4gICAgICAgIG9wYWNpdHk6IDAsXG4gICAgICAgIGNhbGxiYWNrOiBudWxsLFxuICAgIH07XG5cbiAgICBPYmplY3QuYXNzaWduKG9wdGlvbnMsIF9vcHRpb25zKTtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDE7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gb3B0aW9ucy5kaXNwbGF5IHx8IFwiYmxvY2tcIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb24gPSBgJHtvcHRpb25zLmR1cmF0aW9ufW1zIG9wYWNpdHkgZWFzZWA7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IG9wdGlvbnMub3BhY2l0eTtcbiAgICB9LCA1KTtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBcIm5vbmVcIjtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb25cIik7XG4gICAgICAgICEhb3B0aW9ucy5jYWxsYmFjayAmJiBvcHRpb25zLmNhbGxiYWNrKCk7XG4gICAgfSwgb3B0aW9ucy5kdXJhdGlvbiArIDUwKTtcbn07XG5cbmV4cG9ydCBjb25zdCBmYWRlVG9nZ2xlID0gKGVsZW1lbnQsIG9wdGlvbnMpID0+IHtcbiAgICB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5kaXNwbGF5ID09PSBcIm5vbmVcIiA/IGZhZGVJbihlbGVtZW50LCBvcHRpb25zKSA6IGZhZGVPdXQoZWxlbWVudCwgb3B0aW9ucyk7XG59O1xuXG5leHBvcnQgY29uc3Qgb2Zmc2V0ID0gKGVsZW1lbnQpID0+IHtcbiAgICBpZiAoIWVsZW1lbnQuZ2V0Q2xpZW50UmVjdHMoKS5sZW5ndGgpIHtcbiAgICAgICAgcmV0dXJuIHsgdG9wOiAwLCBsZWZ0OiAwIH07XG4gICAgfVxuXG4gICAgLy8gR2V0IGRvY3VtZW50LXJlbGF0aXZlIHBvc2l0aW9uIGJ5IGFkZGluZyB2aWV3cG9ydCBzY3JvbGwgdG8gdmlld3BvcnQtcmVsYXRpdmUgZ0JDUlxuICAgIGNvbnN0IHJlY3QgPSBlbGVtZW50LmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgIGNvbnN0IHdpbiA9IGVsZW1lbnQub3duZXJEb2N1bWVudC5kZWZhdWx0VmlldztcbiAgICByZXR1cm4ge1xuICAgICAgICB0b3A6IHJlY3QudG9wICsgd2luLnBhZ2VZT2Zmc2V0LFxuICAgICAgICBsZWZ0OiByZWN0LmxlZnQgKyB3aW4ucGFnZVhPZmZzZXQsXG4gICAgfTtcbn07XG5cbmV4cG9ydCBjb25zdCB2aXNpYmxlID0gKGVsZW1lbnQpID0+IHtcbiAgICBpZiAoIWVsZW1lbnQpIHtcbiAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgIH1cblxuICAgIHJldHVybiAhIShlbGVtZW50Lm9mZnNldFdpZHRoIHx8IGVsZW1lbnQub2Zmc2V0SGVpZ2h0IHx8IGVsZW1lbnQuZ2V0Q2xpZW50UmVjdHMoKS5sZW5ndGgpO1xufTtcblxuZXhwb3J0IGNvbnN0IGdldFNpYmxpbmdzID0gKGUpID0+IHtcbiAgICAvLyBmb3IgY29sbGVjdGluZyBzaWJsaW5nc1xuICAgIGNvbnN0IHNpYmxpbmdzID0gW107XG5cbiAgICAvLyBpZiBubyBwYXJlbnQsIHJldHVybiBubyBzaWJsaW5nXG4gICAgaWYgKCFlLnBhcmVudE5vZGUpIHtcbiAgICAgICAgcmV0dXJuIHNpYmxpbmdzO1xuICAgIH1cblxuICAgIC8vIGZpcnN0IGNoaWxkIG9mIHRoZSBwYXJlbnQgbm9kZVxuICAgIGxldCBzaWJsaW5nID0gZS5wYXJlbnROb2RlLmZpcnN0Q2hpbGQ7XG5cbiAgICAvLyBjb2xsZWN0aW5nIHNpYmxpbmdzXG4gICAgd2hpbGUgKHNpYmxpbmcpIHtcbiAgICAgICAgaWYgKHNpYmxpbmcubm9kZVR5cGUgPT09IDEgJiYgc2libGluZyAhPT0gZSkge1xuICAgICAgICAgICAgc2libGluZ3MucHVzaChzaWJsaW5nKTtcbiAgICAgICAgfVxuXG4gICAgICAgIHNpYmxpbmcgPSBzaWJsaW5nLm5leHRTaWJsaW5nO1xuICAgIH1cblxuICAgIHJldHVybiBzaWJsaW5ncztcbn07XG5cbi8vIFJldHVybnMgdHJ1ZSBpZiBpdCBpcyBhIERPTSBlbGVtZW50XG5leHBvcnQgY29uc3QgaXNFbGVtZW50ID0gKG8pID0+IHtcbiAgICByZXR1cm4gdHlwZW9mIEhUTUxFbGVtZW50ID09PSBcIm9iamVjdFwiXG4gICAgICAgID8gbyBpbnN0YW5jZW9mIEhUTUxFbGVtZW50IC8vIERPTTJcbiAgICAgICAgOiBvICYmIHR5cGVvZiBvID09PSBcIm9iamVjdFwiICYmIG8gIT09IG51bGwgJiYgby5ub2RlVHlwZSA9PT0gMSAmJiB0eXBlb2Ygby5ub2RlTmFtZSA9PT0gXCJzdHJpbmdcIjtcbn07XG5cbmV4cG9ydCBjb25zdCByZWdpc3RlcldpZGdldCA9IChjbGFzc05hbWUsIHdpZGdldE5hbWUsIHNraW4gPSBcImRlZmF1bHRcIikgPT4ge1xuICAgIGlmICghKGNsYXNzTmFtZSB8fCB3aWRnZXROYW1lKSkge1xuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogQmVjYXVzZSBFbGVtZW50b3IgcGx1Z2luIHVzZXMgalF1ZXJ5IGN1c3RvbSBldmVudCxcbiAgICAgKiBXZSBhbHNvIGhhdmUgdG8gdXNlIGpRdWVyeSB0byB1c2UgdGhpcyBldmVudFxuICAgICAqL1xuICAgIGpRdWVyeSh3aW5kb3cpLm9uKFwiZWxlbWVudG9yL2Zyb250ZW5kL2luaXRcIiwgKCkgPT4ge1xuICAgICAgICBjb25zdCBhZGRIYW5kbGVyID0gKCRlbGVtZW50KSA9PiB7XG4gICAgICAgICAgICBlbGVtZW50b3JGcm9udGVuZC5lbGVtZW50c0hhbmRsZXIuYWRkSGFuZGxlcihjbGFzc05hbWUsIHtcbiAgICAgICAgICAgICAgICAkZWxlbWVudCxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9O1xuXG4gICAgICAgIGVsZW1lbnRvckZyb250ZW5kLmhvb2tzLmFkZEFjdGlvbihgZnJvbnRlbmQvZWxlbWVudF9yZWFkeS8ke3dpZGdldE5hbWV9LiR7c2tpbn1gLCBhZGRIYW5kbGVyKTtcbiAgICB9KTtcbn07XG4iLCJpbXBvcnQgeyByZWdpc3RlcldpZGdldCB9IGZyb20gXCIuLi9saWIvdXRpbHNcIjtcblxuY2xhc3MgT0VXX0dvb2dsZU1hcCBleHRlbmRzIGVsZW1lbnRvck1vZHVsZXMuZnJvbnRlbmQuaGFuZGxlcnMuQmFzZSB7XG4gICAgZ29vZ2xlTWFwO1xuICAgIGluZm9XaW5kb3c7XG5cbiAgICBnZXREZWZhdWx0U2V0dGluZ3MoKSB7XG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBzZWxlY3RvcnM6IHtcbiAgICAgICAgICAgICAgICBnb29nbGVNYXA6IFwiLm9ldy1nb29nbGUtbWFwXCIsXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgYWRkcmVzc2VzOiBbXSxcbiAgICAgICAgICAgIHpvb206IDQsXG4gICAgICAgICAgICBtYXBUeXBlOiBcInJvYWRtYXBcIixcbiAgICAgICAgICAgIG1hcmtlckFuaW1hdGlvbjogbnVsbCxcbiAgICAgICAgICAgIHN0cmVldFZpZXdDb250cm9sOiBmYWxzZSxcbiAgICAgICAgICAgIG1hcFR5cGVDb250cm9sOiBmYWxzZSxcbiAgICAgICAgICAgIHpvb21Db250cm9sOiBmYWxzZSxcbiAgICAgICAgICAgIGZ1bGxzY3JlZW5Db250cm9sOiBmYWxzZSxcbiAgICAgICAgICAgIHNjcm9sbFRvWm9vbTogXCJub25lXCIsXG4gICAgICAgICAgICBzdHlsZXM6IFtdLFxuICAgICAgICB9O1xuICAgIH1cblxuICAgIGdldERlZmF1bHRFbGVtZW50cygpIHtcbiAgICAgICAgY29uc3QgZWxlbWVudCA9IHRoaXMuJGVsZW1lbnQuZ2V0KDApO1xuICAgICAgICBjb25zdCBzZWxlY3RvcnMgPSB0aGlzLmdldFNldHRpbmdzKFwic2VsZWN0b3JzXCIpO1xuXG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBnb29nbGVNYXA6IGVsZW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3RvcnMuZ29vZ2xlTWFwKSxcbiAgICAgICAgfTtcbiAgICB9XG5cbiAgICBvbkluaXQoLi4uYXJncykge1xuICAgICAgICBzdXBlci5vbkluaXQoLi4uYXJncyk7XG5cbiAgICAgICAgdGhpcy5zZXRVc2VyU2V0dGluZ3MoKTtcbiAgICAgICAgdGhpcy5pbml0R29vZ2xlTWFwKCk7XG4gICAgfVxuXG4gICAgaW5pdEdvb2dsZU1hcCgpIHtcbiAgICAgICAgY29uc3QgZ29vZ2xlTWFwT3B0aW9ucyA9IHRoaXMuZ2V0R29vZ2xlTWFwT3B0aW9ucygpO1xuICAgICAgICB0aGlzLmdvb2dsZU1hcCA9IG5ldyBnb29nbGUubWFwcy5NYXAodGhpcy5lbGVtZW50cy5nb29nbGVNYXAsIGdvb2dsZU1hcE9wdGlvbnMpO1xuXG4gICAgICAgIHRoaXMuc2V0QWRkcmVzc2VzKCk7XG4gICAgfVxuXG4gICAgZ2V0R29vZ2xlTWFwT3B0aW9ucygpIHtcbiAgICAgICAgY29uc3Qgc2V0dGluZ3MgPSB0aGlzLmdldFNldHRpbmdzKCk7XG4gICAgICAgIGNvbnN0IGxhdGl0dWRlID0gc2V0dGluZ3MuYWRkcmVzc2VzWzBdWzBdO1xuICAgICAgICBjb25zdCBsb25naXR1ZGUgPSBzZXR0aW5ncy5hZGRyZXNzZXNbMF1bMV07XG5cbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIGNlbnRlcjogbmV3IGdvb2dsZS5tYXBzLkxhdExuZyhsYXRpdHVkZSwgbG9uZ2l0dWRlKSxcbiAgICAgICAgICAgIHpvb206IHNldHRpbmdzLnpvb20sXG4gICAgICAgICAgICBtYXBUeXBlSWQ6IHNldHRpbmdzLm1hcFR5cGUsXG4gICAgICAgICAgICBzdHJlZXRWaWV3Q29udHJvbDogc2V0dGluZ3Muc3RyZWV0Vmlld0NvbnRyb2wsXG4gICAgICAgICAgICBtYXBUeXBlQ29udHJvbDogc2V0dGluZ3MubWFwVHlwZUNvbnRyb2wsXG4gICAgICAgICAgICB6b29tQ29udHJvbDogc2V0dGluZ3Muem9vbUNvbnRyb2wsXG4gICAgICAgICAgICBmdWxsc2NyZWVuQ29udHJvbDogc2V0dGluZ3MuZnVsbHNjcmVlbkNvbnRyb2wsXG4gICAgICAgICAgICBnZXN0dXJlSGFuZGxpbmc6IHNldHRpbmdzLnNjcm9sbFRvWm9vbSxcbiAgICAgICAgICAgIHN0eWxlczogc2V0dGluZ3Muc3R5bGVzLFxuICAgICAgICB9O1xuICAgIH1cblxuICAgIHNldEFkZHJlc3NlcygpIHtcbiAgICAgICAgY29uc3Qgc2V0dGluZ3MgPSB0aGlzLmdldFNldHRpbmdzKCk7XG5cbiAgICAgICAgc2V0dGluZ3MuYWRkcmVzc2VzLmZvckVhY2goKGFkZHJlc3MpID0+IHtcbiAgICAgICAgICAgIGNvbnN0IGFkZHJlc3NMYXRpdHVkZSA9IGFkZHJlc3NbMF07XG4gICAgICAgICAgICBjb25zdCBhZGRyZXNzTG9uZ2l0dWRlID0gYWRkcmVzc1sxXTtcbiAgICAgICAgICAgIGNvbnN0IGFkZHJlc3NUaXRsZSA9IGFkZHJlc3NbM107XG5cbiAgICAgICAgICAgIGlmICghIWFkZHJlc3NMYXRpdHVkZSAmJiAhIWFkZHJlc3NMb25naXR1ZGUpIHtcbiAgICAgICAgICAgICAgICBjb25zdCBtYXJrZXJJY29uVHlwZSA9IGFkZHJlc3NbNV07XG4gICAgICAgICAgICAgICAgY29uc3QgbWFya2VySWNvblVSTCA9IGFkZHJlc3NbNl07XG4gICAgICAgICAgICAgICAgY29uc3QgbWFya2VySWNvblNpemUgPSBhZGRyZXNzWzddO1xuXG4gICAgICAgICAgICAgICAgLy8gU2V0IGFkZHJlc3MgbWFya2VyXG4gICAgICAgICAgICAgICAgY29uc3QgbWFya2VyID0gdGhpcy5jcmVhdGVNYXJrZXIoXG4gICAgICAgICAgICAgICAgICAgIGFkZHJlc3NMYXRpdHVkZSxcbiAgICAgICAgICAgICAgICAgICAgYWRkcmVzc0xvbmdpdHVkZSxcbiAgICAgICAgICAgICAgICAgICAgYWRkcmVzc1RpdGxlLFxuICAgICAgICAgICAgICAgICAgICBtYXJrZXJJY29uVHlwZSxcbiAgICAgICAgICAgICAgICAgICAgbWFya2VySWNvblVSTCxcbiAgICAgICAgICAgICAgICAgICAgbWFya2VySWNvblNpemVcbiAgICAgICAgICAgICAgICApO1xuXG4gICAgICAgICAgICAgICAgY29uc3QgZW5hYmxlSW5mb1dpbmRvdyA9IGFkZHJlc3NbMl07XG4gICAgICAgICAgICAgICAgY29uc3QgZW5hYmxlSW5mb1dpbmRvd09uRG9jdW1lbnRMb2FkID0gYWRkcmVzc1s4XTtcbiAgICAgICAgICAgICAgICBjb25zdCBpbmZvV2luZG93RGVzY3JpcHRpb24gPSBhZGRyZXNzWzRdO1xuXG4gICAgICAgICAgICAgICAgaWYgKCEhZW5hYmxlSW5mb1dpbmRvdyAmJiBhZGRyZXNzVGl0bGUpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc3QgaW5mb1dpbmRvdyA9IHRoaXMuY3JlYXRlSW5mb1dpbmRvdyhtYXJrZXIsIGFkZHJlc3NUaXRsZSwgaW5mb1dpbmRvd0Rlc2NyaXB0aW9uKTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoISFlbmFibGVJbmZvV2luZG93T25Eb2N1bWVudExvYWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGluZm9XaW5kb3cub3Blbih0aGlzLmdvb2dsZU1hcCwgbWFya2VyKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIGdvb2dsZS5tYXBzLmV2ZW50LmFkZExpc3RlbmVyKG1hcmtlciwgXCJjbGlja1wiLCAoKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpbmZvV2luZG93Lm9wZW4odGhpcy5nb29nbGVNYXAsIG1hcmtlcik7XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgICAgIGdvb2dsZS5tYXBzLmV2ZW50LmFkZExpc3RlbmVyKHRoaXMuZ29vZ2xlTWFwLCBcImNsaWNrXCIsICgpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGluZm9XaW5kb3cuY2xvc2UoKTtcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBjcmVhdGVNYXJrZXIoYWRkcmVzc0xhdGl0dWRlLCBhZGRyZXNzTG9uZ2l0dWRlLCBhZGRyZXNzVGl0bGUsIG1hcmtlckljb25UeXBlLCBtYXJrZXJJY29uVVJMLCBtYXJrZXJJY29uU2l6ZSkge1xuICAgICAgICBjb25zdCBtYXJrZXJBbmltYXRpb24gPSB0aGlzLmdldFNldHRpbmdzKFwibWFya2VyQW5pbWF0aW9uXCIpO1xuICAgICAgICBsZXQgYW5pbWF0aW9uID0gbnVsbDtcblxuICAgICAgICBzd2l0Y2ggKG1hcmtlckFuaW1hdGlvbikge1xuICAgICAgICAgICAgY2FzZSBcImRyb3BcIjpcbiAgICAgICAgICAgICAgICBhbmltYXRpb24gPSBnb29nbGUubWFwcy5BbmltYXRpb24uRFJPUDtcbiAgICAgICAgICAgICAgICBicmVhaztcblxuICAgICAgICAgICAgY2FzZSBcImJvdW5jZVwiOlxuICAgICAgICAgICAgICAgIGFuaW1hdGlvbiA9IGdvb2dsZS5tYXBzLkFuaW1hdGlvbi5CT1VOQ0U7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gbmV3IGdvb2dsZS5tYXBzLk1hcmtlcih7XG4gICAgICAgICAgICBwb3NpdGlvbjogbmV3IGdvb2dsZS5tYXBzLkxhdExuZyhhZGRyZXNzTGF0aXR1ZGUsIGFkZHJlc3NMb25naXR1ZGUpLFxuICAgICAgICAgICAgbWFwOiB0aGlzLmdvb2dsZU1hcCxcbiAgICAgICAgICAgIHRpdGxlOiBhZGRyZXNzVGl0bGUsXG4gICAgICAgICAgICBhbmltYXRpb246IGFuaW1hdGlvbixcbiAgICAgICAgICAgIGljb246XG4gICAgICAgICAgICAgICAgbWFya2VySWNvblR5cGUgPT09IFwiY3VzdG9tXCJcbiAgICAgICAgICAgICAgICAgICAgPyB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIHVybDogbWFya2VySWNvblVSTCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgc2NhbGVkU2l6ZTogbmV3IGdvb2dsZS5tYXBzLlNpemUobWFya2VySWNvblNpemUsIG1hcmtlckljb25TaXplKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgb3JpZ2luOiBuZXcgZ29vZ2xlLm1hcHMuUG9pbnQoMCwgMCksXG4gICAgICAgICAgICAgICAgICAgICAgICAgIGFuY2hvcjogbmV3IGdvb2dsZS5tYXBzLlBvaW50KDAsIDApLFxuICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgOiBcIlwiLFxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBjcmVhdGVJbmZvV2luZG93KG1hcmtlciwgYWRkcmVzc1RpdGxlLCBpbmZvV2luZG93RGVzY3JpcHRpb24pIHtcbiAgICAgICAgY29uc3QgaW5mb1dpbmRvd09wdGlub3MgPSB7fTtcbiAgICAgICAgY29uc3QgZGF0YXNldE1heFdpZHRoID0gdGhpcy5lbGVtZW50cy5nb29nbGVNYXAuZGF0YXNldC5pd01heFdpZHRoO1xuXG4gICAgICAgIGluZm9XaW5kb3dPcHRpbm9zLmNvbnRlbnQgPSBgXG4gICAgICAgIDxkaXYgY2xhc3M9XCJvZXctaW5mb3dpbmRvdy1jb250ZW50XCI+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwib2V3LWluZm93aW5kb3ctdGl0bGVcIj4ke2FkZHJlc3NUaXRsZX08L2Rpdj5cbiAgICAgICAgICAgICR7ISFpbmZvV2luZG93RGVzY3JpcHRpb24gPyBgPGRpdiBjbGFzcz1cIm9ldy1pbmZvd2luZG93LWRlc2NyaXB0aW9uXCI+JHtpbmZvV2luZG93RGVzY3JpcHRpb259PC9kaXY+YCA6IGBgfVxuICAgICAgICA8L2Rpdj5gO1xuXG4gICAgICAgIGlmICghIWRhdGFzZXRNYXhXaWR0aCkge1xuICAgICAgICAgICAgaW5mb1dpbmRvd09wdGlub3MubWF4V2lkdGggPSBkYXRhc2V0TWF4V2lkdGg7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gbmV3IGdvb2dsZS5tYXBzLkluZm9XaW5kb3coaW5mb1dpbmRvd09wdGlub3MpO1xuICAgIH1cblxuICAgIHNldFVzZXJTZXR0aW5ncygpIHtcbiAgICAgICAgY29uc3Qgc2V0dGluZ3MgPSB0aGlzLmdldFNldHRpbmdzKCk7XG4gICAgICAgIGNvbnN0IGRhdGFzZXRTZXR0aW5ncyA9IHRoaXMuZWxlbWVudHMuZ29vZ2xlTWFwLmRhdGFzZXQ7XG4gICAgICAgIGNvbnN0IGVsZW1lbnRTZXR0aW5ncyA9IHRoaXMuZ2V0RWxlbWVudFNldHRpbmdzKCk7XG5cbiAgICAgICAgY29uc3QgYWRkcmVzc2VzID0gISFkYXRhc2V0U2V0dGluZ3MubG9jYXRpb25zID8gSlNPTi5wYXJzZShkYXRhc2V0U2V0dGluZ3MubG9jYXRpb25zKSA6IHNldHRpbmdzLmFkZHJlc3NlcztcbiAgICAgICAgY29uc3Qgem9vbSA9ICFOdW1iZXIuaXNOYU4oTnVtYmVyKGRhdGFzZXRTZXR0aW5ncy56b29tKSkgPyBOdW1iZXIoZGF0YXNldFNldHRpbmdzLnpvb20pIDogc2V0dGluZ3Muem9vbTtcbiAgICAgICAgY29uc3QgbWFwVHlwZSA9ICEhZWxlbWVudFNldHRpbmdzLm1hcF90eXBlID8gZWxlbWVudFNldHRpbmdzLm1hcF90eXBlIDogc2V0dGluZ3MubWFwVHlwZTtcbiAgICAgICAgY29uc3Qgem9vbUNvbnRyb2wgPSAhIWVsZW1lbnRTZXR0aW5ncy56b29tX2NvbnRyb2wgPyBlbGVtZW50U2V0dGluZ3Muem9vbV9jb250cm9sIDogc2V0dGluZ3Muem9vbUNvbnRyb2w7XG4gICAgICAgIGNvbnN0IHN0eWxlcyA9ICEhZGF0YXNldFNldHRpbmdzLmN1c3RvbVN0eWxlID8gSlNPTi5wYXJzZShkYXRhc2V0U2V0dGluZ3MuY3VzdG9tU3R5bGUpIDogc2V0dGluZ3Muc3R5bGVzO1xuXG4gICAgICAgIGNvbnN0IG1hcmtlckFuaW1hdGlvbiA9ICEhZWxlbWVudFNldHRpbmdzLm1hcmtlcl9hbmltYXRpb25cbiAgICAgICAgICAgID8gZWxlbWVudFNldHRpbmdzLm1hcmtlcl9hbmltYXRpb25cbiAgICAgICAgICAgIDogc2V0dGluZ3MubWFya2VyQW5pbWF0aW9uO1xuXG4gICAgICAgIGNvbnN0IHN0cmVldFZpZXdDb250cm9sID0gISFlbGVtZW50U2V0dGluZ3MubWFwX29wdGlvbl9zdHJlZXR2aWV3XG4gICAgICAgICAgICA/IGVsZW1lbnRTZXR0aW5ncy5tYXBfb3B0aW9uX3N0cmVldHZpZXdcbiAgICAgICAgICAgIDogc2V0dGluZ3Muc3RyZWV0Vmlld0NvbnRyb2w7XG5cbiAgICAgICAgY29uc3QgbWFwVHlwZUNvbnRyb2wgPSAhIWVsZW1lbnRTZXR0aW5ncy5tYXBfdHlwZV9jb250cm9sXG4gICAgICAgICAgICA/IGVsZW1lbnRTZXR0aW5ncy5tYXBfdHlwZV9jb250cm9sXG4gICAgICAgICAgICA6IHNldHRpbmdzLm1hcFR5cGVDb250cm9sO1xuXG4gICAgICAgIGNvbnN0IGZ1bGxzY3JlZW5Db250cm9sID0gISFlbGVtZW50U2V0dGluZ3MuZnVsbHNjcmVlbl9jb250cm9sXG4gICAgICAgICAgICA/IGVsZW1lbnRTZXR0aW5ncy5mdWxsc2NyZWVuX2NvbnRyb2xcbiAgICAgICAgICAgIDogc2V0dGluZ3MuZnVsbHNjcmVlbkNvbnRyb2w7XG5cbiAgICAgICAgY29uc3Qgc2Nyb2xsVG9ab29tID0gISFlbGVtZW50U2V0dGluZ3MubWFwX3Njcm9sbF96b29tID8gZWxlbWVudFNldHRpbmdzLm1hcF9zY3JvbGxfem9vbSA6IHNldHRpbmdzLnNjcm9sbFRvWm9vbTtcblxuICAgICAgICB0aGlzLnNldFNldHRpbmdzKHtcbiAgICAgICAgICAgIGFkZHJlc3NlczogYWRkcmVzc2VzLFxuICAgICAgICAgICAgem9vbTogem9vbSxcbiAgICAgICAgICAgIG1hcFR5cGU6IG1hcFR5cGUsXG4gICAgICAgICAgICBtYXJrZXJBbmltYXRpb246IG1hcmtlckFuaW1hdGlvbixcbiAgICAgICAgICAgIHN0cmVldFZpZXdDb250cm9sOiBzdHJlZXRWaWV3Q29udHJvbCxcbiAgICAgICAgICAgIG1hcFR5cGVDb250cm9sOiBtYXBUeXBlQ29udHJvbCxcbiAgICAgICAgICAgIHpvb21Db250cm9sOiB6b29tQ29udHJvbCxcbiAgICAgICAgICAgIGZ1bGxzY3JlZW5Db250cm9sOiBmdWxsc2NyZWVuQ29udHJvbCxcbiAgICAgICAgICAgIHNjcm9sbFRvWm9vbTogc2Nyb2xsVG9ab29tLFxuICAgICAgICAgICAgc3R5bGVzOiBzdHlsZXMsXG4gICAgICAgIH0pO1xuICAgIH1cbn1cblxucmVnaXN0ZXJXaWRnZXQoT0VXX0dvb2dsZU1hcCwgXCJvZXctZ29vZ2xlLW1hcFwiKTtcbiJdfQ==
