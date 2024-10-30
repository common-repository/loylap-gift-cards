window.onload = function () {

try{
    document.getElementById("dropdown-toggle").addEventListener("mouseenter", showcontent);
    document.getElementById("dropdown-toggle").addEventListener("mouseleave", hidecontent);
    
    document.getElementById("dropdown-toggle").addEventListener("click", togglecontent);
    
}catch(e){
    // if the element is not found we now won't give an error and silently fail
    // originally I had it print to the console 
}

};

function togglecontent (e){
    let display = document.getElementById("dropdown-content").style.display;
    
    document.getElementById("dropdown-content").style.display = display == "block" ? "none": "block";
}

function showcontent(e){
    document.getElementById("dropdown-content").style.display = "block" ;

}

function hidecontent(e){
    document.getElementById("dropdown-content").style.display = "none" ;

}