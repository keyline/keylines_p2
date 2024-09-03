(function ($) {

"use strict";

var maze, whatwg, game;

maze = {
	cnv: null,
	ctx: null,
	inDraw: false,
	img: new Image(),

	init: function () {
		this.cnv = $("#mazecnv");
		if (!this.cnv[0].getContext) {
			return;
		}
		this.ctx = maze.cnv[0].getContext("2d");
		this.ctx.strokeStyle = "rgb(255, 0, 0)";
		this.img.src = "maze.png";
		this.load();
		this.cnv.on({
			mousedown: $.proxy(this.beginPath, this),
			"mouseup mouseout": $.proxy(this.stopPath, this),
			mousemove: $.proxy(this.drawPath, this)
		});
		$(".maze-clear").click($.proxy(this.load, this));
	},

	load: function () {
		this.ctx.clearRect(0, 0, this.cnv.prop("width"), this.cnv.prop("height"));
		if (this.img.complete) {
			this.ctx.drawImage(this.img, 0, 0);
		} else {
			this.img.onload = $.proxy(function () {
				this.ctx.drawImage(this.img, 0, 0);
			}, this);
		}
	},

	beginPath: function (e) {
		var pos = this.cnv.offset();
		this.ctx.beginPath();
		this.ctx.moveTo(e.pageX - pos.left + e.target.parentNode.scrollLeft,
			e.pageY - pos.top);
		this.inDraw = true;
	},

	stopPath: function () {
		if (this.inDraw) {
			this.inDraw = false;
			this.ctx.stroke();
		}
	},

	drawPath: function (e) {
		var pos;
		if (this.inDraw) {
			pos = this.cnv.offset();
			this.ctx.lineTo(e.pageX - pos.left + e.target.parentNode.scrollLeft,
				e.pageY - pos.top);
			this.ctx.stroke();
		}
	}
};

whatwg = {
	checkboxes: $(".view-cols input[type='checkbox']"),

	init: function () {
		$("body").on("click", ".view-cols input[type='checkbox']", $.proxy(this.filterTable, this));
	},

	filterTable: function (e) {
		var index;
		if (this.checkboxes.filter(":checked").length === 0) {
			this.checkboxes.prop("checked", true);
			$("#input-type-attr-summary").find(".cell-hidden").removeClass("cell-hidden");
		} else {
			index = $.inArray(e.target, this.checkboxes.get()) + 2;
			if (index > 1) {
				$("#input-type-attr-summary").find("td, th").filter(":nth-child(" + index + ")")
					.toggleClass("cell-hidden");
			}
		}
		$(".whatwg").trigger("adjustScroll");
	}
};

game = {
	mapCode: "l4sl5s11l16s5l2s2l4s8ls3l13s11l3s4ls4ls3l13s2l2s7l3s2l3s2l2s4l5sl6" +
		"s4l3s6l2s2l5s9ls11l4s5l10s9ls11l7s6l7s4l2s3ls9l10s5l7s4l2s3ls7ls2l8s6" +
		"l4s7l2sl2s5l3sl6s8l5s3ls4l6s2l2s4l3s10l6s2l3s3l9s4l4s7l5s4l4s2lsl8s3l5" +
		"s7l3s5l8slsl7s2l4s8l3s5l7s3l8s2l3sl3s4l4s5ls2lsls2l4sl7s4l3s5l4s6l2s4" +
		"l2s4l7s2lslsls4l4sls2l2s2ls5l3s4l2s3ls4l2s3l3sl3sl2sl3s4l2s8l3s3l6s2" +
		"l13s7l3s3l3slsls2l2s4l2s2l10s5l3s4lsl4s7l2s4l5sl4s4l3s8ls8l2s4l4s2l2s4" +
		"l4s18l5s2ls9l5sl3s14l7s3ls6l9s15ls4l2s8l7s18l2s3l4s5l7s6l3s9l2s4l6sl10" +
		"s5l5s7l2s4l15s5l7sls2lsl3s5l13s3l9s2ls3l2s7l5s2l2sl2s4l6s6ls11l3s13l2s" +
		"ls6ls14ls12l4s8l2s4l4s11ls6l3s9l3s2l7s8ls11ls5l5s2l4s16l2s3l2s6l5s2l3" +
		"s3ls10l6s3l5s3l9s3ls5ls2l5sl2s4l4s2l10sl9sl5s9l3sl10s2l15s3ls6l2sl10s3" +
		"l14s3ls7l",
	currCell: null,
	rowIndex: 0,
	colIndex: 1,
	fieldSize: 40,

	init: function () {
		var key2Method = {
			"87": "stepUp", // W
			"68": "stepRight", // D
			"83": "stepDown", // S
			"65": "stepLeft", // A
			"45": "buildFortress", // Ins
			"46": "razeFortress" // Del
		};
		$(document).keyup($.proxy(function (e) {
			var key = e.keyCode.toString();
			if (key2Method.hasOwnProperty(key)) {
				this[key2Method[key]]();
			}
		}, this));
		this.createPlayingField();
		this.expandMap();
	},

	createPlayingField: function () {
		var gameBox = $(".game-box"),
			html = "<table class='game-map' cellspacing='0' id='game'>",
			helperArray = new Array(this.fieldSize + 1),
			tr = "<tr>" + helperArray.join("<td></td>") + "</tr>";
		html += helperArray.join(tr);
		html += "</table>";
		gameBox.append(html);
		this.currCell = $(".game-map tr").eq(this.rowIndex).find("td").eq(this.colIndex);
		this.currCell.addClass("current");
		this.getMooreNeighborhood().addClass("explored");
	},

	expandMap: function () {
		var classesArr = this.mapCode.replace(/\d+/g, function (count, index, str) {
			return (new Array(+count)).join(str.charAt(index - 1));
		}).split("");
		$(".game-map td").addClass(function (index) {
			return classesArr[index];
		});
	},

	setCurrentCell: function (cell) {
		this.currCell.removeClass("current");
		this.currCell = cell;
		this.currCell.addClass("current");
		this.colIndex = this.currCell.index();
		this.rowIndex = this.currCell.parent().index();
	},

	getMooreNeighborhood: function () {
		var topIndex = Math.max(this.rowIndex - 1, 0),
			bottomIndex = Math.min(this.rowIndex + 1, this.fieldSize),
			leftIndex = Math.max(this.colIndex - 1, 0),
			rightIndex = Math.min(this.colIndex + 1, this.fieldSize),
			cells = $();
		$(".game-map tr").slice(topIndex, bottomIndex + 1).each(function () {
			cells = cells.add($(this).find("td").slice(leftIndex, rightIndex + 1));
		});
		return cells;
	},

	exploreMooreNeighborhood: function (cell) {
		this.setCurrentCell(cell);
		this.getMooreNeighborhood().addClass("explored");
	},

	stepUp: function () {
		var cell;
		if (this.rowIndex > 0) {
			cell = this.currCell.parent().prev("tr").find("td").eq(this.colIndex);
			this.exploreMooreNeighborhood(cell);
		}
	},

	stepRight: function () {
		if (this.colIndex < this.fieldSize - 1) {
			this.exploreMooreNeighborhood(this.currCell.next("td"));
		}
	},

	stepDown: function () {
		var cell;
		if (this.rowIndex < this.fieldSize - 1) {
			cell = this.currCell.parent().next("tr").find("td").eq(this.colIndex);
			this.exploreMooreNeighborhood(cell);
		}
	},

	stepLeft: function () {
		if (this.colIndex > 0) {
			this.exploreMooreNeighborhood(this.currCell.prev("td"));
		}
	},

	buildFortress: function () {
		if (!this.currCell.hasClass("s")) {
			this.currCell.addClass("fortress");
		}
	},

	razeFortress: function () {
		this.currCell.removeClass("fortress");
	}
};

maze.init();
whatwg.init();
game.init();

$(document).ready(function () {
	var containers = $(".maze, .whatwg, .game-box");
	containers.attachScroll();
	$("body").on("click", ".demo-src-block summary", function () {
		containers.trigger("adjustScroll");
	});
});

})(window.jQuery);