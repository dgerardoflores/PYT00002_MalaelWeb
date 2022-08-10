/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Declare vars
	var api = wp.customize;

	api('ofc_callout_text', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-callout-content' ).html( newval );
		});
	});
	api('ofc_callout_button_txt', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-callout-button a' ).text( newval );
		});
	});
	api( 'ofc_callout_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_top_padding">#footer-callout-wrap { padding-top: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_bottom_padding">#footer-callout-wrap { padding-bottom: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_tablet_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_tablet_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_tablet_top_padding">@media (max-width: 768px){#footer-callout-wrap { padding-top: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_tablet_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_tablet_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_tablet_bottom_padding">@media (max-width: 768px){#footer-callout-wrap { padding-bottom: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_mobile_top_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_mobile_top_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_mobile_top_padding">@media (max-width: 480px){#footer-callout-wrap { padding-top: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_mobile_bottom_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_mobile_bottom_padding' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_mobile_bottom_padding">@media (max-width: 480px){#footer-callout-wrap { padding-bottom: ' + to + 'px; }}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_bg', function( value ) {
		value.bind( function( to ) {
			$( '#footer-callout-wrap' ).css( 'background-color', to );
		} );
	} );
	api( 'ofc_callout_border', function( value ) {
		value.bind( function( to ) {
			$( '#footer-callout-wrap' ).css( 'border-color', to );
		} );
	} );
	api( 'ofc_callout_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer-callout-wrap' ).css( 'color', to );
		} );
	} );
	api( 'ofc_callout_links_color', function( value ) {
		value.bind( function( to ) {
			$( '.footer-callout-content a' ).css( 'color', to );
		} );
	} );
	api( 'ofc_callout_links_color_hover', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_links_color_hover' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_links_color_hover">.footer-callout-content a:hover { color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_button_border_radius', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_button_border_radius' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_button_border_radius">#footer-callout .callout-button { border-radius: ' + to + 'px; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_button_bg', function( value ) {
		value.bind( function( to ) {
			$( '#footer-callout .callout-button' ).css( 'background-color', to );
		} );
	} );
	api( 'ofc_callout_button_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer-callout .callout-button' ).css( 'color', to );
		} );
	} );
	api( 'ofc_callout_button_hover_bg', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_button_hover_bg' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_button_hover_bg">#footer-callout .callout-button:hover { background-color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	api( 'ofc_callout_button_hover_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-ofc_callout_button_hover_color' );
			if ( to ) {
				var style = '<style class="customizer-ofc_callout_button_hover_color">#footer-callout .callout-button:hover { color: ' + to + '!important; }</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
    api( 'ofc_callout_text_typo_font_family', function(value) {
        value.bind( function( to ) {
            if ( to ) {
                var idfirst     = ( to.trim().toLowerCase().replace( ' ', '-' ), 'customizer-ofc_callout_text_typo_font_family' );
                var font        = to.replace( ' ', '%20' );
                    font        = font.replace( ',', '%2C' );
                    font        = ofc_callout.googleFontsUrl + '/css?family=' + to + ':' + ofc_callout.googleFontsWeight;

                if ( $( '#' + idfirst ).length ) {
                    $( '#' + idfirst ).attr( 'href', font );
                } else {
                    $( 'head' ).append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + font + '">' );
                }
            }
            var $child = $( '.customizer-ofc_callout_text_typo_font_family' );
            if ( to ) {
                var style = '<style class="customizer-ofc_callout_text_typo_font_family">#footer-callout .footer-callout-content{font-family: ' + to + ';}</style>';
                if ( $child.length ) {
                    $child.replaceWith( style );
                } else {
                    $( 'head' ).append( style );
                }
            } else {
                $child.remove();
            }
        });
    });
    api('ofc_callout_text_typo_font_size', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'font-size', newval );
            }
        });
    });
    api('ofc_callout_text_typo_font_weight', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'font-weight', newval );
            }
        });
    });
    api('ofc_callout_text_typo_font_style', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'font-style', newval );
            }
        });
    });
    api('ofc_callout_text_typo_transform', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'text-transform', newval );
            }
        });
    });
    api('ofc_callout_text_typo_line_height', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'line-height', newval );
            }
        });
    });
    api('ofc_callout_text_typo_spacing', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .footer-callout-content' ).css( 'letter-spacing', newval );
            }
        });
    });
    api( 'ofc_callout_button_typo_font_family', function(value) {
        value.bind( function( to ) {
            if ( to ) {
                var idfirst     = ( to.trim().toLowerCase().replace( ' ', '-' ), 'customizer-ofc_callout_button_typo_font_family' );
                var font        = to.replace( ' ', '%20' );
                    font        = font.replace( ',', '%2C' );
                    font        = ofc_callout.googleFontsUrl + '/css?family=' + to + ':' + ofc_callout.googleFontsWeight;

                if ( $( '#' + idfirst ).length ) {
                    $( '#' + idfirst ).attr( 'href', font );
                } else {
                    $( 'head' ).append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + font + '">' );
                }
            }
            var $child = $( '.customizer-ofc_callout_button_typo_font_family' );
            if ( to ) {
                var style = '<style class="customizer-ofc_callout_button_typo_font_family">#footer-callout .callout-button{font-family: ' + to + ';}</style>';
                if ( $child.length ) {
                    $child.replaceWith( style );
                } else {
                    $( 'head' ).append( style );
                }
            } else {
                $child.remove();
            }
        });
    });
    api('ofc_callout_button_typo_font_size', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'font-size', newval );
            }
        });
    });
    api('ofc_callout_button_typo_font_weight', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'font-weight', newval );
            }
        });
    });
    api('ofc_callout_button_typo_font_style', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'font-style', newval );
            }
        });
    });
    api('ofc_callout_button_typo_transform', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'text-transform', newval );
            }
        });
    });
    api('ofc_callout_button_typo_line_height', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'line-height', newval );
            }
        });
    });
    api('ofc_callout_button_typo_spacing', function( value ) {
        value.bind( function( newval ) {
            if ( newval ) {
                $( '#footer-callout .callout-button' ).css( 'letter-spacing', newval );
            }
        });
    });
} )( jQuery );
