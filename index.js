document.getElementById("close").onmousedown = function (e) {
  e.preventDefault();
  document.getElementById("info").style.display = "none";
  return false;
};

// settings

var physics_accuracy = 3,
  mouse_influence = 20,
  mouse_cut = 5,
  gravity = 1200,
  cloth_height = 30,
  cloth_width = 50,
  start_y = 20,
  spacing = 7,
  tear_distance = 60;

window.requestAnimFrame =
  window.requestAnimationFrame ||
  window.webkitRequestAnimationFrame ||
  window.mozRequestAnimationFrame ||
  window.oRequestAnimationFrame ||
  window.msRequestAnimationFrame ||
  function (callback) {
    window.setTimeout(callback, 1000 / 60);
  };

var canvas,
  ctx,
  cloth,
  boundsx,
  boundsy,
  mouse = {
    down: false,
    button: 1,
    x: 0,
    y: 0,
    px: 0,
    py: 0,
  };

var Point = function (x, y) {
  this.x = x;
  this.y = y;
  this.px = x;
  this.py = y;
  this.vx = 0;
  this.vy = 0;
  this.pin_x = null;
  this.pin_y = null;

  this.constraints = [];
};

Point.prototype.update = function (delta) {
  if (mouse.down) {
    var diff_x = this.x - mouse.x,
      diff_y = this.y - mouse.y,
      dist = Math.sqrt(diff_x * diff_x + diff_y * diff_y);

    if (mouse.button == 1) {
      if (dist < mouse_influence) {
        this.px = this.x - (mouse.x - mouse.px) * 1.8;
        this.py = this.y - (mouse.y - mouse.py) * 1.8;
      }
    } else if (dist < mouse_cut) this.constraints = [];
  }

  this.add_force(0, gravity);

  delta *= delta;
  nx = this.x + (this.x - this.px) * 0.99 + (this.vx / 2) * delta;
  ny = this.y + (this.y - this.py) * 0.99 + (this.vy / 2) * delta;

  this.px = this.x;
  this.py = this.y;

  this.x = nx;
  this.y = ny;

  this.vy = this.vx = 0;
};

Point.prototype.draw = function () {
  if (!this.constraints.length) return;

  var i = this.constraints.length;
  while (i--) this.constraints[i].draw();
};

Point.prototype.resolve_constraints = function () {
  if (this.pin_x != null && this.pin_y != null) {
    this.x = this.pin_x;
    this.y = this.pin_y;
    return;
  }

  var i = this.constraints.length;
  while (i--) this.constraints[i].resolve();

  this.x > boundsx
    ? (this.x = 2 * boundsx - this.x)
    : 1 > this.x && (this.x = 2 - this.x);
  this.y < 1
    ? (this.y = 2 - this.y)
    : this.y > boundsy && (this.y = 2 * boundsy - this.y);
};

Point.prototype.attach = function (point) {
  this.constraints.push(new Constraint(this, point));
};

Point.prototype.remove_constraint = function (constraint) {
  this.constraints.splice(this.constraints.indexOf(constraint), 1);
};

Point.prototype.add_force = function (x, y) {
  this.vx += x;
  this.vy += y;

  var round = 400;
  this.vx = ~~(this.vx * round) / round;
  this.vy = ~~(this.vy * round) / round;
};

Point.prototype.pin = function (pinx, piny) {
  this.pin_x = pinx;
  this.pin_y = piny;
};

var Constraint = function (p1, p2) {
  this.p1 = p1;
  this.p2 = p2;
  this.length = spacing;
};

Constraint.prototype.resolve = function () {
  var diff_x = this.p1.x - this.p2.x,
    diff_y = this.p1.y - this.p2.y,
    dist = Math.sqrt(diff_x * diff_x + diff_y * diff_y),
    diff = (this.length - dist) / dist;

  if (dist > tear_distance) this.p1.remove_constraint(this);

  var px = diff_x * diff * 0.5;
  var py = diff_y * diff * 0.5;

  this.p1.x += px;
  this.p1.y += py;
  this.p2.x -= px;
  this.p2.y -= py;
};

Constraint.prototype.draw = function () {
  ctx.moveTo(this.p1.x, this.p1.y);
  ctx.lineTo(this.p2.x, this.p2.y);
};

var Cloth = function () {
  this.points = [];

  var start_x = canvas.width / 2 - (cloth_width * spacing) / 2;

  for (var y = 0; y <= cloth_height; y++) {
    for (var x = 0; x <= cloth_width; x++) {
      var p = new Point(start_x + x * spacing, start_y + y * spacing);

      x != 0 && p.attach(this.points[this.points.length - 1]);
      y == 0 && p.pin(p.x, p.y);
      y != 0 && p.attach(this.points[x + (y - 1) * (cloth_width + 1)]);

      this.points.push(p);
    }
  }
};

Cloth.prototype.update = function () {
  var i = physics_accuracy;

  while (i--) {
    var p = this.points.length;
    while (p--) this.points[p].resolve_constraints();
  }

  i = this.points.length;
  while (i--) this.points[i].update(0.016);
};

Cloth.prototype.draw = function () {
  ctx.beginPath();

  var i = cloth.points.length;
  while (i--) cloth.points[i].draw();

  ctx.stroke();
};

function update() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  cloth.update();
  cloth.draw();

  requestAnimFrame(update);
}

function start() {
  canvas.onmousedown = function (e) {
    mouse.button = e.which;
    mouse.px = mouse.x;
    mouse.py = mouse.y;
    var rect = canvas.getBoundingClientRect();
    (mouse.x = e.clientX - rect.left),
      (mouse.y = e.clientY - rect.top),
      (mouse.down = true);
    e.preventDefault();
  };

  canvas.onmouseup = function (e) {
    mouse.down = false;
    e.preventDefault();
  };

  canvas.onmousemove = function (e) {
    mouse.px = mouse.x;
    mouse.py = mouse.y;
    var rect = canvas.getBoundingClientRect();
    (mouse.x = e.clientX - rect.left),
      (mouse.y = e.clientY - rect.top),
      e.preventDefault();
  };

  canvas.oncontextmenu = function (e) {
    e.preventDefault();
  };

  boundsx = canvas.width - 1;
  boundsy = canvas.height - 1;

  ctx.strokeStyle = "#888";

  cloth = new Cloth();

  update();
}

window.onload = function () {
  canvas = document.getElementById("c");
  ctx = canvas.getContext("2d");

  canvas.width = 560;
  canvas.height = 350;

  start();
};

//ANIMATION
var points = [],
  velocity2 = 5, // velocity squared
  canvas = document.getElementById("animated"),
  context = canvas.getContext("2d"),
  radius = 5,
  boundaryX = 200,
  boundaryY = 200,
  numberOfPoints = 30;

init();

function init() {
  // create points
  for (var i = 0; i < numberOfPoints; i++) {
    createPoint();
  }
  // create connections
  for (var i = 0, l = points.length; i < l; i++) {
    var point = points[i];
    if (i == 0) {
      points[i].buddy = points[points.length - 1];
    } else {
      points[i].buddy = points[i - 1];
    }
  }

  // animate
  animate();
}

function createPoint() {
  var point = {},
    vx2,
    vy2;
  point.x = Math.random() * boundaryX;
  point.y = Math.random() * boundaryY;
  // random vx
  point.vx = (Math.floor(Math.random()) * 2 - 1) * Math.random();
  vx2 = Math.pow(point.vx, 2);
  // vy^2 = velocity^2 - vx^2
  vy2 = velocity2 - vx2;
  point.vy = Math.sqrt(vy2) * (Math.random() * 2 - 1);
  points.push(point);
}

function resetVelocity(point, axis, dir) {
  var vx, vy;
  if (axis == "x") {
    point.vx = dir * Math.random();
    vx2 = Math.pow(point.vx, 2);
    // vy^2 = velocity^2 - vx^2
    vy2 = velocity2 - vx2;
    point.vy = Math.sqrt(vy2) * (Math.random() * 2 - 1);
  } else {
    point.vy = dir * Math.random();
    vy2 = Math.pow(point.vy, 2);
    // vy^2 = velocity^2 - vx^2
    vx2 = velocity2 - vy2;
    point.vx = Math.sqrt(vx2) * (Math.random() * 2 - 1);
  }
}

function drawCircle(x, y) {
  context.beginPath();
  context.arc(x, y, radius, 0, 2 * Math.PI, false);
  context.fillStyle = "#97badc";
  context.fill();
}

function drawLine(x1, y1, x2, y2) {
  context.beginPath();
  context.moveTo(x1, y1);
  context.lineTo(x2, y2);
  context.strokeStyle = "#8ab2d8";
  context.stroke();
}

function draw() {
  for (var i = 0, l = points.length; i < l; i++) {
    // circles
    var point = points[i];
    point.x += point.vx;
    point.y += point.vy;
    drawCircle(point.x, point.y);
    // lines
    drawLine(point.x, point.y, point.buddy.x, point.buddy.y);
    // check for edge
    if (point.x < 0 + radius) {
      resetVelocity(point, "x", 1);
    } else if (point.x > boundaryX - radius) {
      resetVelocity(point, "x", -1);
    } else if (point.y < 0 + radius) {
      resetVelocity(point, "y", 1);
    } else if (point.y > boundaryY - radius) {
      resetVelocity(point, "y", -1);
    }
  }
}

function animate() {
  context.clearRect(0, 0, 200, 200);
  draw();
  requestAnimationFrame(animate);
}

// TimeClock Display
function showTime() {
  var date = new Date();
  var h = date.getHours(); // 0 - 23
  var m = date.getMinutes(); // 0 - 59
  var s = date.getSeconds(); // 0 - 59
  var session = "AM";

  if (h == 0) {
    h = 12;
  }

  if (h > 12) {
    h = h - 12;
    session = "PM";
  }

  h = h < 10 ? "0" + h : h;
  m = m < 10 ? "0" + m : m;
  s = s < 10 ? "0" + s : s;

  var time = h + ":" + m + ":" + s + " " + session;
  document.getElementById("MyClockDisplay").innerText = time;
  document.getElementById("MyClockDisplay").textContent = time;

  setTimeout(showTime, 1000);
}

showTime();

// navbar
var prevScrollpos = window.pageYOffset;
window.onscroll = function () {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("Navbar").style.top = "0";
  } else {
    document.getElementById("Navbar").style.top = "-80px";
  }
  prevScrollpos = currentScrollPos;
};

// ToolTip

$("#tooltip").click(function () {
  $("#tooltip").mouseover();
});

// Random quotes
writeRandomQuote = function () {
  var quotes = new Array();
  quotes[0] = "Action is the real meassure of intelligence.";
  quotes[1] =
    "Blessed are they who see beautiful things in humble places where other people see nothing.";
  quotes[2] =
    " When a deep injury is done us, we never recover until we forgive.";
  quotes[3] =
    "A good head and a good heart are always a formidable combination.";
  quotes[3] =
    "A good head and a good heart are always a formidable combination.";
  quotes[4] =
    "The beautiful thing about learning is nobody can take it away from you.";
  quotes[5] =
    "The human voice is the most beautiful instrument of all, but it is the most difficult to play.";

  var rand = Math.floor(Math.random() * quotes.length);
  document.getElementById("quote").innerHTML = quotes[rand];
};
writeRandomQuote();

$(window).scroll(function () {
  $("#quotes")
    .stop()
    .animate(
      {
        marginTop: $(window).scrollTop() + "px",
        marginLeft: $(window).scrollLeft() + "px",
      },
      "slow"
    );
  ScrollFunction();
});

//needs work
$(document).ready(() => {
  setInterval(() => {
    writeRandomQuote().trigger("click");
  }, 5000);
});

//alert top nav

window.setTimeout(function () {
  $(".popUp")
    .fadeTo(500, 0)
    .slideUp(500, function () {
      $(this).remove();
    });
}, 1200);

$(document).ready(function () {
  // Hide the div
  $("#quotes").hide();

  // Show the div in 5s
  $("#quotes").delay(3500).fadeIn(500);
});

//
$(document).ready(function () {
  // Hide the div
  $(".btn-cmt").hide();

  // Show the div in 5s
  $(".btn-cmt").delay(4000).fadeIn(500);
});

//
window.setTimeout(function () {
  $(".btn-cmt")
    .fadeTo(500, 0)
    .slideUp(500, function () {
      $(this).remove();
    });
}, 8000);

$(document).ready(function () {
  $(".toggle").click(function () {
    $(".toggle").toggleClass("active");
    $("nav ul").toggleClass("active-menu");
  });
});

// No right click
var message =
  "Sorry right-click is disable, contact me if you would like to know the contents.";

function clickIE4() {
  if (event.button == 2) {
    alert(message);
    return false;
  }
}

function clickNS4(e) {
  if (document.layers || (document.getElementById && !document.all)) {
    if (e.which == 2 || e.which == 3) {
      alert(message);
      return false;
    }
  }
}

if (document.layers) {
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown = clickNS4;
} else if (document.all && !document.getElementById) {
  document.onmousedown = clickIE4;
}
document.oncontextmenu = new Function("alert(message);return false");


// validation Jquery
$("form").submit(function (e) {
  var error = "";

  if ($("#email").val() == "") {
    error += "The email field is required.<br>";
  }
  if ($("#subject").val() == "") {
    error += "Your name is required.<br>";
  }

  if ($("#content").val() == "") {
    error += "The content field is required.<br>";
  }

  if (error != "") {
    $("#error").html(
      '<div class="alert alert-danger" role="alert"><p><strong>There were error(s) in your form:</strong></p>' +
        error +
        "</div>"
    );

    return false;
  } else {
    return true;
  }
});

// function([string1, string2],target id,[color1,color2])
consoleText(["Let's Work.", "Let's expand.", "With efficiency"], "text", [
  "#8AAAE5",
  "#ADD8E6",
  "lightblue",
]);

function consoleText(words, id, colors) {
  if (colors === undefined) colors = ["#fff"];
  var visible = true;
  var con = document.getElementById("console");
  var letterCount = 1;
  var x = 1;
  var waiting = false;
  var target = document.getElementById(id);
  target.setAttribute("style", "color:" + colors[0]);
  window.setInterval(function () {
    if (letterCount === 0 && waiting === false) {
      waiting = true;
      target.innerHTML = words[0].substring(0, letterCount);
      window.setTimeout(function () {
        var usedColor = colors.shift();
        colors.push(usedColor);
        var usedWord = words.shift();
        words.push(usedWord);
        x = 1;
        target.setAttribute("style", "color:" + colors[0]);
        letterCount += x;
        waiting = false;
      }, 1000);
    } else if (letterCount === words[0].length + 1 && waiting === false) {
      waiting = true;
      window.setTimeout(function () {
        x = -1;
        letterCount += x;
        waiting = false;
      }, 1000);
    } else if (waiting === false) {
      target.innerHTML = words[0].substring(0, letterCount);
      letterCount += x;
    }
  }, 120);
  window.setInterval(function () {
    if (visible === true) {
      con.className = "console-underscore hidden";
      visible = false;
    } else {
      con.className = "console-underscore";

      visible = true;
    }
  }, 400);
}
