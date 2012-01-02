/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var running=false;
var script =0;
var seqno=0;
var drinkval =0;
var timer = 0;
var timercount = 0;
var dukes = 0;

function ImageArray(n){
    this.length=n;
    for(var i=1;i<=n; i++) this[i] = new Image();
    return this;    
}

function loadAllImages(){
    dukes = new ImageArray(16);
    dukes[1].src="./images/T1.gif";
    dukes[2].src="./images/T2.gif";
    dukes[3].src="./images/T3.gif";
    dukes[4].src="./images/T4.gif";
    dukes[5].src="./images/T5.gif";
    dukes[6].src="./images/T6.gif";
    dukes[7].src="./images/T7.gif";
    dukes[8].src="./images/T8.gif";
    dukes[9].src="./images/T9.gif";
    dukes[10].src="./images/T10.gif";
    dukes[11].src="./images/T11.gif";
    dukes[12].src="./images/T12.gif";
    dukes[13].src="./images/T13.gif";
    dukes[14].src="./images/T14.gif";
    dukes[15].src="./images/T21.gif";
    dukes[16].src="./images/T20.gif";
    
    
}

function script1(){
    var chk = timercount % 5;
    if(chk==0){
        var javalecturer = document.getElementById('duke');
        seqno = (seqno+1) % 2;
        if(seqno==1){
            javalecturer.src =dukes[2].src;
        }
        else {
            javalecturer.src =dukes[1].src;
        }
    }
    
}

function script2(){
    var chk = timercount % 3;
    if(chk==0){
        var javalecturer = document.getElementById('duke');
        seqno = (seqno+1) % 5;
        switch(seqno){
            case 0:
                javalecturer.src = dukes[3].src;
                break;
            case 1:
                javalecturer.src = dukes[11].src;
                break;
            case 2:
                javalecturer.src = dukes[13].src;
                break;
            case 3:
                javalecturer.src = dukes[1].src;
                break;
            case 4:
                javalecturer.src = dukes[12].src;
                break;
        }
        
    }
    
}

function script3(){
     var javalecturer = document.getElementById('duke');
        seqno = (seqno+1) % 10;
        switch(seqno){
            case 0:
                javalecturer.src = dukes[3].src;
                javalecturer.style.left="200px";
                break;
            case 1:
                javalecturer.src = dukes[11].src;
                 javalecturer.style.top="420px";
                break;
            case 2:
                javalecturer.src = dukes[5].src;
                 javalecturer.style.left="180px";
                  javalecturer.style.top="380px";
                break;
            case 3:
                javalecturer.src = dukes[7].src;
                 javalecturer.style.left="500px";
                break;
            case 4:
                javalecturer.src = dukes[9].src;
                 javalecturer.style.left="360px";
                  javalecturer.style.top="480px";
                break;
            case 5:
                javalecturer.src = dukes[8].src;
                 javalecturer.style.left="420px";
                  javalecturer.style.top="400px";
                break;
            case 6:
                javalecturer.src = dukes[14].src;
                 javalecturer.style.left="460px";
                  javalecturer.style.top="400px";
                break;
            case 7:
                javalecturer.src = dukes[11].src;
                 javalecturer.style.left="500px";
                  javalecturer.style.top="480px";
                break;
            case 8:
                javalecturer.src = dukes[6].src;
                 javalecturer.style.left="420px";
                  javalecturer.style.top="460px";
                break;
            case 9:
                javalecturer.src = dukes[9].src;
                 javalecturer.style.left="320px";
                  javalecturer.style.top="480px";
                break;
}
}

function script4(){
    var chk = timercount % 10;
    if(chk==0){
        var javalecturer = document.getElementById('duke');
        seqno = (seqno+1) % 4;
        switch(seqno){
            case 0:
                javalecturer.src = dukes[11].src;
                javalecturer.style.display='block';
                javalecturer.style.opacity=0.6;
                break;
            case 1:
                javalecturer.src = dukes[15].src;
                javalecturer.style.display='block';
                javalecturer.style.opacity=0.6;
                break;
            case 2:
               javalecturer.src = dukes[16].src;
                javalecturer.style.display='block';
                javalecturer.style.opacity=0.3;
                break;
            case 3:
                javalecturer.style.display='none';
                break;
        }
    
}
}

function animation(){
    timercount++;
    switch(drinkval){
        case 1:
            script1();
            break;
        case 2:
            script2();
            break;
        case 3:
            script3();
            break;
        case 4:
            script4();
            break;
    }
    timer=setTimeout(animation,100);
}

function repositionDuke(){
 
 var javalecturer = document.getElementById('duke');
 javalecturer.src=dukes[1].src;
 javalecturer.style.left="330px";
 javalecturer.style.top="500px";
 javalecturer.style.display="block";
 javalecturer.style.opacity=1.0;
}

function getDrinks(){
 
 var drinksbox=document.getElementById('drinks');
 var index =drinksbox.selectedIndex;
 drinkval = 1 +index;
}

function doAnimate(){
    
    var buttoncontrol = document.getElementById('startstop');
    if(dukes==0)
        loadAllImages();
    if(running){
        running = false;
        buttoncontrol.value="Start";
        clearTimeout(timer);
    }
    else{
        running=true;
        buttoncontrol.value="Stop";
        repositionDuke();
        seqno=0;
        getDrinks();
        timer=setTimeout(animation, 100);
    }
}

    

