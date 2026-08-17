function profiletogglebar(){
    document.getElementById("profile").classList.toggle('active');
}
function uploadprofile(){
    document.getElementById('upload').click();
}
function showEmojiPanel(){
    document.getElementById('emoji').removeAttribute("style"); 
}
function hideEmojiPanel(){
    document.getElementById('emoji').setAttribute('style','display:none');
}
function getEmoji(control){
    document.getElementById('textmsg').value += control.textContent;
    console.log(control);
}
