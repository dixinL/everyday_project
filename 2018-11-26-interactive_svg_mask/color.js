console.clear();
var svg = document.querySelector("#demo");
var tl = new TimelineMax({onUpdate:onUpdate});
var pt = svg.createSVGPoint();
var data = document.querySelector(".tlProgress");
var counter = document.querySelector("#counter");
var ratio = 0.5625;

TweenMax.set("#instructions, #dial", {xPercent: -50});
TweenMax.set("#progressRing", {drawSVG:0});

tl.to("#masker", 2, {attr:{r:2400}, ease:Power2.easeIn});
tl.reversed(true);

function mouseHandler() {
    tl.reversed(!tl.reversed());
}

function getPoint(evt){
    pt.x = evt.clientX;
    pt.y = evt.clientY;
    return pt.matrixTransform(svg.getScreenCTM().inverse());
}

function mouseMove(evt) {
    var newPoint = getPoint(evt);
    TweenMax.set("#dot", {attr:{cx:newPoint.x, cy:newPoint.y}});
    TweenMax.to("#ring, #masker", 0.88, {attr:{cx:newPoint.x, cy:newPoint.y}, ease:Power2.easeOut});
}

function onUpdate() {
    var prog = (tl.progress() * 100);
    TweenMax.set("#progressRing", {drawSVG:prog + "%"});
    counter.textContent = prog.toFixed();
}

function newSize() {
    var w = window.innerWidth ;
    var h = window.innerHeight;
    if (w > h * (16/9) ) {
        TweenMax.set("#demo", { attr: { width: w, height: w * ratio } });
    } else {
        TweenMax.set("#demo", { attr: { width: h / ratio, height: h } });
    }
    var data = svg.getBoundingClientRect();
    TweenMax.set("#demo", {x:w/2 - data.width/2});
    TweenMax.set("#demo", {y:h/2 - data.height/2});
}

window.addEventListener("mousedown", mouseHandler);
window.addEventListener("mouseup", mouseHandler);
window.addEventListener("mousemove", mouseMove);

newSize();
window.addEventListener("resize", newSize);