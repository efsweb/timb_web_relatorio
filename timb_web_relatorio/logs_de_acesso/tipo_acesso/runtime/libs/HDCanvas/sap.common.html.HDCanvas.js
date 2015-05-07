/**
 * @author Jove Shi
 */
(function () {
	
	// make sure undefined is undefined
	var undefined;
	
	if(window){
		sap = window.sap || {};
	}else{
		sap = sap || {};
	}
		
	// Specially for sap.common.globalization as APP Root	
	if(sap){
		sap.common = sap.common || {};	
	}
	if(sap.common){
		sap.common.html =  sap.common.html || {};
	}
	if(sap.common.html){
		sap.common.html.HDCanvas =  sap.common.html.HDCanvas || {};
	}
	
	/**
	 * Version number like 1.0.0.
	 * 
	 * @return {String} the version number
	 * @public
	 * @static
	 */
	sap.common.html.HDCanvas.VERSION = function() {return "6.2.0";};
	
	/**
	 * Build number like 100.
	 * 
	 * @return {Number} the build number
	 * @public
	 * @static
	 */
	// Do NOT change the BUILD function including the coding format, 
	// it will be auto-updated by build script.
	sap.common.html.HDCanvas.BUILD = function() {return 1121;};
	
	/**
	 * @private
	 * Debug flag to force set screen ratio. 
	 */
	sap.common.html.HDCanvas._DEBUG_FORCE_SCREEN_RATIO = null;
	
	var hasNativeCanvas = (document.createElement('canvas').getContext != undefined);
	
	var parseScreenRatio = function(screenRatio) {
		if(sap.common.html.HDCanvas._DEBUG_FORCE_SCREEN_RATIO){
			screenRatio = sap.common.html.HDCanvas._DEBUG_FORCE_SCREEN_RATIO;
		}
		var screenRatio = Number(screenRatio);
		if(isNaN(screenRatio) || screenRatio <= 0){
			screenRatio = (window.devicePixelRatio ? window.devicePixelRatio : 1);
		}
		return screenRatio;
	};
	
	var trimLeft = /^\s+/, trimRight = /\s+$/;
	var trim = function(text) {
		return text == null ?
			"" :
			text.toString().replace( trimLeft, "" ).replace( trimRight, "" );
	}
	
	/**
	 * @public
	 * Enable HTMLCanvasElement to support different screen ratios.
	 * Only applies the screenRatio called in the first time. 
	 * When Canvas is enabled HD, width2 and height2 must be used to set canvas size in px values.
	 * Support IE8+
	 *  
	 * @param htmlCanvas {HTMLCanvasElement} 
	 * 		The canvas to be converted to HDCanvas
	 * @param screenRatio {Number} 
	 * 		Optional, force to set the screenRatio. 
	 * 		If screenRatio is not available, use window default screenRatio. 
	 */
	sap.common.html.HDCanvas.enableHD = function(htmlCanvas/*HTMLCanvasElement*/, screenRatio){
		screenRatio = parseScreenRatio(screenRatio);
		
		var wrapCanvas = hasNativeCanvas;
		
		// ONLY for debug
		if(sap.common.html.HDCanvas._DEBUG_FORCE_SCREEN_RATIO === "disabled"){
			wrapCanvas = false;
		}
		if(screenRatio == 1){
			// if screenRatio is 1, return htmlCanvas directly
			// BUT this require testing on both devices to ensure the HDCanvas and HTMLCanvasElement work as the same.
			wrapCanvas = false;
		}
		
		if(wrapCanvas){
			// only allow enable once, 
			// and suppose the screen ratio will no be dynamically changed in one page.
			if(!htmlCanvas._hd_enabled){
				Object.defineProperty(htmlCanvas, "width2", {
				    get: function() {
				    	return this.offsetWidth;
				    },
				    set: function(value) {
				    	var screenWidth = value;
						var rawWidth = value * this._hd_screen_ratio;
						if(this.width != rawWidth){
							this.width = rawWidth;	
						}
						if(this.style.width != (screenWidth + "px")){
							this.style.width = screenWidth + "px";
						}
				    }
				});
				
				Object.defineProperty(htmlCanvas, "height2", {
				    get: function() {
				    	return this.offsetHeight;
				    },
				    set: function(value) {
				    	var screenHeight = value;
						var rawHeight = value * this._hd_screen_ratio;
						if(this.height != rawHeight){
							this.height = rawHeight;
						}
						if(this.style.height != (screenHeight + "px")){
							this.style.height = screenHeight + "px";
						}
				    }
				});
				
				htmlCanvas.refreshSizeHD = function(){
					var canvasCleaned = false;
					
					// refresh canvas size if it's incorrect for screen ratio
					// in case canvas is not in DOM tree, 
					// because canvas width/height should > 0, 
					// if style is not set, clientWidth must > 0.
					var currentWidth = 0;
					var styleWidth = this.style.width;
					if(styleWidth){
						// should parse the style size for in|cm|mm|pt|pc|em|ex|px
						if(isNaN(Number(styleWidth))){
							var cssWidth = String(styleWidth);
							cssWidth = cssWidth.substring(0, cssWidth.length - 2);
							currentWidth = Number(cssWidth);
						}else{
							currentWidth = Number(styleWidth);
						}
					}else{
						currentWidth = this.offsetWidth;
						if(currentWidth == 0){
							currentWidth = this.width;
						}
					}
					
					var currentHeight = 0;//this.clientHeight;
					var styleHeight = this.style.height;
					if(styleHeight){
						// should parse the style size for in|cm|mm|pt|pc|em|ex|px
						if(isNaN(Number(styleHeight))){
							var cssHeight = String(styleHeight);
							cssHeight = cssHeight.substring(0, cssHeight.length - 2);
							currentHeight = Number(cssHeight);
						}else{
							currentHeight = Number(styleHeight);
						}
					}else{
						currentHeight = this.offsetHeight;
						if(currentHeight == 0){
							currentHeight = this.height;
						}
					}
					
					var canvasWidth = currentWidth * this._hd_screen_ratio;
					var canvasHeight = currentHeight * this._hd_screen_ratio;
					
					if(this.width != canvasWidth){
						this.width2 = currentWidth;
						canvasCleaned = true;
					}
					
					if(this.height != canvasHeight){
						this.height2 = currentHeight;
						canvasCleaned = true;
					}
					return canvasCleaned;
				};
				
				htmlCanvas._raw_getContext = htmlCanvas.getContext;
				
				htmlCanvas.getContext = function(value){
					if(value === "2d"){
						this.refreshSizeHD();
						
						if(!this._hd_context2d){
							this._hd_context2d = new sap.common.html.HDCanvas.HDCanvasRenderingContext2D(this._raw_getContext("2d"), this._hd_screen_ratio); 
						}
						return this._hd_context2d;
					}else{
						this._raw_getContext(value);
					}
				};
				
				htmlCanvas.getScreenRatioHD = function(){
					if(this._hd_enabled){
						return this._hd_screen_ratio;
					}
					return 1;
				}
				
				htmlCanvas._hd_screen_ratio = screenRatio;
				htmlCanvas._hd_context2d = null;
				htmlCanvas._hd_enabled = true;
				
				if(htmlCanvas.parentNode != null){
					htmlCanvas.refreshSizeHD();
				}
			}
		}else{
			if(Object.defineProperty){
				// IE8, mock width2, height2 properties to keep compatible
				Object.defineProperty(htmlCanvas, "width2", {
					get: function(){
						return htmlCanvas.width;
					},
					set: function(value){
						htmlCanvas.width = value; 
					}
				});
				
				Object.defineProperty(htmlCanvas, "height2", {
					get: function(){
						return htmlCanvas.height;
					},
					set: function(value){
						htmlCanvas.height = value; 
					}
				});
				
				htmlCanvas.refreshSizeHD = function(){
					return false;
				};
				
				htmlCanvas.getScreenRatioHD = function(){
					return 1;
				}
			}
		}
		return htmlCanvas;
	};
	
	// IE8- does not need following methods
	if(!hasNativeCanvas){
		return;
	}
	
	//--------------------------------
	// HDCanvasGradient Wrapper
	//--------------------------------
	
	sap.common.html.HDCanvas.HDCanvasGradient = function (htmlCanvasGradient/*CanvasRenderingContext2D*/, screenRatio) {
		this.__className = "sap.common.html.HDCanvas.HDCanvasGradient";
		
		this._htmlCanvasGradient = htmlCanvasGradient;
		
		this._screenRatio = screenRatio;
	};
	
	sap.common.html.HDCanvas.HDCanvasGradient.prototype.addColorStop = function(offset, color){
		return this._htmlCanvasGradient.addColorStop(offset, color);
	};
	
	//--------------------------------
	// HDCanvasGradient Wrapper
	//--------------------------------
	
	sap.common.html.HDCanvas.HDCanvasPattern = function (htmlCanvasPattern /*CanvasRenderingContext2D*/, screenRatio) {
		this.__className = "sap.common.html.HDCanvas.HDCanvasPattern";
		
		this._htmlCanvasPattern = htmlCanvasPattern;
		
		this._screenRatio = screenRatio;
	};
	
	//--------------------------------
	// CanvasRenderingContext2D Wrapper
	//--------------------------------
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D = function (htmlCanvasContext2D/*CanvasRenderingContext2D*/, screenRatio) {
		this.__className = "sap.common.html.HDCanvas.HDCanvasRenderingContext2D";
		
		this._htmlCanvasContext2D = htmlCanvasContext2D;
		
		this._screenRatio = screenRatio;
		
		this._strokeStyle = null;
		this._fillStyle = null;
		
		this._lineWidth = 0;
		this._miterLimit = 0;
		
		this._shadowOffsetX = 0;
		this._shadowOffsetY = 0;
		
		this._font = "";
		
		this.lineWidth = this._htmlCanvasContext2D.lineWidth;
		this.miterLimit = this._htmlCanvasContext2D.miterLimit;
		this.shadowOffsetX = this._htmlCanvasContext2D.shadowOffsetX;
		this.shadowOffsetY = this._htmlCanvasContext2D.shadowOffsetY;
		
		this.font = this._htmlCanvasContext2D.font;
		
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.save = function(){
		return this._htmlCanvasContext2D.save();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.restore = function(){
		return this._htmlCanvasContext2D.restore();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.scale = function(x, y){
		return this._htmlCanvasContext2D.scale(x, y);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.rotate = function(angle){
		return this._htmlCanvasContext2D.rotate(angle);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.translate = function(x, y){
		return this._htmlCanvasContext2D.translate(x * this._screenRatio, y * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.transform = function(m11, m12, m21, m22, dx, dy){
		return this._htmlCanvasContext2D.transform(m11, m12, m21, m22, dx, dy);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.setTransform = function(m11, m12, m21, m22, dx, dy){
		return this._htmlCanvasContext2D.setTransform(m11, m12, m21, m22, dx, dy);
	};
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "globalAlpha", {
	    get: function() {
	    	return this._htmlCanvasContext2D.globalAlpha;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.globalAlpha = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "globalCompositeOperation", {
	    get: function() {
	    	return this._htmlCanvasContext2D.globalCompositeOperation;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.globalCompositeOperation = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "strokeStyle", {
	    get: function() {
	    	return this._strokeStyle;
	    },
	    set: function(value) {
	    	if(value instanceof sap.common.html.HDCanvas.HDCanvasGradient){
	    		this._htmlCanvasContext2D.strokeStyle = value._htmlCanvasGradient;
	    	}else if(value instanceof sap.common.html.HDCanvas.HDCanvasPattern){
	    		this._htmlCanvasContext2D.strokeStyle = value._htmlCanvasPattern;
	    	}else{
	    		this._htmlCanvasContext2D.strokeStyle = value;	
	    	}
	    	this._strokeStyle = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "fillStyle", {
	    get: function() {
	    	return this._fillStyle;
	    },
	    set: function(value) {
	    	if(value instanceof sap.common.html.HDCanvas.HDCanvasGradient){
	    		this._htmlCanvasContext2D.fillStyle = value._htmlCanvasGradient;
	    	}else if(value instanceof sap.common.html.HDCanvas.HDCanvasPattern){
	    		this._htmlCanvasContext2D.fillStyle = value._htmlCanvasPattern;
	    	}else{
	    		this._htmlCanvasContext2D.fillStyle = value;	
	    	}
	    	this._fillStyle = value;
	    }
	});
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.createLinearGradient = function(x0, y0, x1, y1){
		return new sap.common.html.HDCanvas.HDCanvasGradient(this._htmlCanvasContext2D.createLinearGradient(x0 * this._screenRatio, y0 * this._screenRatio, x1 * this._screenRatio, y1  *this._screenRatio), this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.createRadialGradient = function(x0, y0, r0, x1, y1, r1){
		return new sap.common.html.HDCanvas.HDCanvasGradient(this._htmlCanvasContext2D.createRadialGradient(x0 * this._screenRatio, y0 * this._screenRatio, r0 * this._screenRatio, x1 * this._screenRatio, y1 * this._screenRatio, r1 * this._screenRatio), this._screenRatio);
	};
	
	/**
	 * TODO
	 * There's a limitation:
	 * When HD enabled HTMLCanvasElement is used to cratePattern for another raw (non-HD enabled) HTMLCanvasElement,
	 * the filled content size will multiply the HD enabled HTMLCanvasElement's screen ratio
	 */
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.createPattern = function(image, repetition){
		var toDrawnCanvasScreenRatio = 1;
		if(image && image._hd_enabled && image._hd_screen_ratio){
			toDrawnCanvasScreenRatio = image._hd_screen_ratio;
		}
		var tempCanvas = document.createElement("CANVAS");
		tempCanvas.width = image.width * this._screenRatio / toDrawnCanvasScreenRatio;
		tempCanvas.height = image.height * this._screenRatio / toDrawnCanvasScreenRatio;
		tempCanvas.getContext("2d").drawImage(image, 0, 0, tempCanvas.width, tempCanvas.height);
		var p = new sap.common.html.HDCanvas.HDCanvasPattern(this._htmlCanvasContext2D.createPattern(tempCanvas, repetition), this._screenRatio);
		tempCanvas = null;
		return p;
	};
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "lineWidth", {
	    get: function() {
	    	return this._lineWidth;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.lineWidth = value * this._screenRatio;
	    	this._lineWidth = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "lineCap", {
	    get: function() {
	    	return this._htmlCanvasContext2D.lineCap;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.lineCap = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "lineJoin", {
	    get: function() {
	    	return this._htmlCanvasContext2D.lineJoin;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.lineJoin = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "miterLimit", {
	    get: function() {
	    	return this._miterLimit;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.miterLimit = value * this._screenRatio;
	    	this._miterLimit = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "shadowOffsetX", {
	    get: function() {
	    	return this._shadowOffsetX;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.shadowOffsetX = value * this._screenRatio;
	    	this._shadowOffsetX = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "shadowOffsetY", {
	    get: function() {
	    	return this._shadowOffsetY;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.shadowOffsetY = value * this._screenRatio;
	    	this._shadowOffsetY = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "shadowBlur", {
	    get: function() {
	    	return this._htmlCanvasContext2D.shadowBlur;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.shadowBlur = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "shadowColor", {
	    get: function() {
	    	return this._htmlCanvasContext2D.shadowColor;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.shadowColor = value;
	    }
	});
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.clearRect = function(x, y, w, h){
		return this._htmlCanvasContext2D.clearRect(x * this._screenRatio, y * this._screenRatio, w * this._screenRatio, h * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.fillRect = function(x, y, w, h){
		return this._htmlCanvasContext2D.fillRect(x * this._screenRatio, y * this._screenRatio, w * this._screenRatio, h * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.strokeRect = function(x, y, w, h){
		return this._htmlCanvasContext2D.strokeRect(x * this._screenRatio, y * this._screenRatio, w * this._screenRatio, h * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.beginPath = function(){
		return this._htmlCanvasContext2D.beginPath();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.closePath = function(){
		return this._htmlCanvasContext2D.closePath();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.moveTo = function(x, y){
		return this._htmlCanvasContext2D.moveTo(x * this._screenRatio, y * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.lineTo = function(x, y){
		return this._htmlCanvasContext2D.lineTo(x * this._screenRatio, y * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.quadraticCurveTo = function(cpx, cpy, x, y){
		return this._htmlCanvasContext2D.quadraticCurveTo(cpx * this._screenRatio, cpy * this._screenRatio, x * this._screenRatio, y * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.bezierCurveTo = function(cp1x, cp1y, cp2x, cp2y, x, y){
		return this._htmlCanvasContext2D.bezierCurveTo(cp1x * this._screenRatio, cp1y * this._screenRatio, cp2x * this._screenRatio, cp2y * this._screenRatio, x * this._screenRatio, y * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.arcTo = function(x1, y1, x2, y2, radius){
		return this._htmlCanvasContext2D.arcTo(x1 * this._screenRatio, y1 * this._screenRatio, x2 * this._screenRatio, y2 * this._screenRatio, radius * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.rect = function(x, y, w, h){
		return this._htmlCanvasContext2D.rect(x * this._screenRatio, y * this._screenRatio, w * this._screenRatio, h * this._screenRatio);
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.arc = function(x, y, radius, startAngle, endAngle, anticlockwise){
		if(anticlockwise != undefined){
			return this._htmlCanvasContext2D.arc(x * this._screenRatio, y * this._screenRatio, radius * this._screenRatio, startAngle, endAngle, anticlockwise);
		}else{
			return this._htmlCanvasContext2D.arc(x * this._screenRatio, y * this._screenRatio, radius * this._screenRatio, startAngle, endAngle);
		}
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.fill = function(){
		return this._htmlCanvasContext2D.fill();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.stroke = function(){
		return this._htmlCanvasContext2D.stroke();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.clip = function(){
		return this._htmlCanvasContext2D.clip();
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.isPointInPath = function(x, y){
		return this._htmlCanvasContext2D.isPointInPath(x * this._screenRatio, y * this._screenRatio);
	};
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "font", {
	    get: function() {
	    	return this._font;
	    },
	    set: function(value) {
	    	var fontStr = " " + value;
			var reg = /\s\d{1,}(in|cm|mm|pt|pc|em|ex|px)/g;
			var tokens = reg.exec(fontStr);
			var size = tokens[0];
			var unit = tokens[1];
			if(size && unit && size.length > 2){
				size = size.substring(0, size.length - 2);
				if(size){
					size = Number(size);
					if(isNaN(size) == false){
						fontStr = fontStr.replace(reg, " " + (size * this._screenRatio) + unit);
					}
				}
			}
	    	this._htmlCanvasContext2D.font = trim(fontStr);
	    	this._font = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "textAlign", {
	    get: function() {
	    	return this._htmlCanvasContext2D.textAlign;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.textAlign = value;
	    }
	});
	
	Object.defineProperty(sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype, "textBaseline", {
	    get: function() {
	    	return this._htmlCanvasContext2D.textBaseline;
	    },
	    set: function(value) {
	    	this._htmlCanvasContext2D.textBaseline = value;
	    }
	});
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.fillText = function(text, x, y, maxWidth){
		if(maxWidth != undefined){
			this._htmlCanvasContext2D.fillText(text, x * this._screenRatio, y * this._screenRatio, maxWidth * this._screenRatio);
		}else{
			this._htmlCanvasContext2D.fillText(text, x * this._screenRatio, y * this._screenRatio);
		}
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.strokeText = function(text, x, y, maxWidth){
		if(maxWidth != undefined){
			this._htmlCanvasContext2D.strokeText(text, x * this._screenRatio, y * this._screenRatio, maxWidth * this._screenRatio);
		}else{
			this._htmlCanvasContext2D.strokeText(text, x * this._screenRatio, y * this._screenRatio);
		}
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.measureText = function(text){
		var tm = this._htmlCanvasContext2D.measureText(text);
		var tm2 = {width: tm.width, height: tm.height};
		if(tm.width){
			tm2.width = tm.width / this._screenRatio;
		}
		if(tm.height){
			tm2.height = tm.height / this._screenRatio;
		}
		return tm2;
	};
	
	/**
	 * TODO
	 * There's a limitation:
	 * When HD enabled HTMLCanvasElement is drawn into another raw (non-HD enabled) HTMLCanvasElement,
	 * the drawn content size will multiply the HD enabled HTMLCanvasElement's screen ratio.
	 * Suggest to draw the HD enabled HTMLCanvasElement with dw and dh calculated by its getScreenRatioHD().
	 */
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.drawImage = function(image, dx, dy, dw, dh){
		var toDrawnCanvasScreenRatio = 1;
		if(image && image._hd_enabled && image._hd_screen_ratio){
			toDrawnCanvasScreenRatio = image._hd_screen_ratio;
		}
		if(dw != undefined && dh != undefined){
			return this._htmlCanvasContext2D.drawImage(image, dx * this._screenRatio, dy * this._screenRatio, dw * this._screenRatio / toDrawnCanvasScreenRatio, dh * this._screenRatio / toDrawnCanvasScreenRatio);
		}else{
			var imgW = image.width;
			var imgH = image.height;
			return this._htmlCanvasContext2D.drawImage(image, dx * this._screenRatio, dy * this._screenRatio, imgW * this._screenRatio / toDrawnCanvasScreenRatio, imgH * this._screenRatio / toDrawnCanvasScreenRatio);
		}
	};
	
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.toDataURL = function(){
		return this._htmlCanvasContext2D.toDataURL();
	};
	
	// TODO
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.createImageData = function(w, h){
		throw new Error("HDCanvasRenderingContext2D does not support createImageData(w, h).");
		// if(h != undefined){
			// return this._htmlCanvasContext2D.createImageData(w, h);
		// }else{
			// return this._htmlCanvasContext2D.createImageData(w);
		// }
	};
	
	// TODO
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.getImageData = function(x, y, w, h){
		throw new Error("HDCanvasRenderingContext2D does not support getImageData(x, y, w, h).");
		// return this._htmlCanvasContext2D.getImageData(x, y, w, h);
	};
	
	// TODO
	sap.common.html.HDCanvas.HDCanvasRenderingContext2D.prototype.putImageData = function(img, x, y, dirtyX, dirtyY, dirtyW, dirtyH){
		throw new Error("HDCanvasRenderingContext2D does not support putImageData(img, x, y, dirtyX, dirtyY, dirtyW, dirtyH).");
		// if(dirtyX != undefined && dirtyY != undefined && dirtyW != undefined && dirtyH != undefined){
			// return this._htmlCanvasContext2D.putImageData(img, x, y, dirtyX, dirtyY, dirtyW, dirtyH);
		// }else{
			// return this._htmlCanvasContext2D.putImageData(img, x, y);
		// }
	};
	
}());