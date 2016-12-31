var s1 = new Snap("#design");
var s2 = new Snap('#s2');

// Design.svg
Snap.load('/assets/images/our_process/process_icons/design.svg', function(response){
var design = response;
s1.append(design);
});

s1.stop().animate({ opacity: 0,transform: 'translate(0,200)'}, 3000, mina.easeout);

//Development.svg
Snap.load('/assets/images/our_process/process_icons/development.svg', function(response){
var dev = response;
s2.append(dev);
});