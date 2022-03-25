/* Variable */
var appLink = 'https://nhentai.my.id';
var appLinkServer = 'https://rizkiirfananshori-games.000webhostapp.com';
var appPremium = false;
/* System Functions */
function setData(input,pada){
    /* simpan data */
    localStorage.setItem(pada, input);
    console.log('Set Data "'+pada+'"');
}  
function loadData(pada){
    /* load data */
    return localStorage.getItem(pada);
    console.log('Load Data "'+pada+'"');
}
function deleteData(pada){
    /* load data */
    return localStorage.removeItem(pada);
    console.log('Delete Data "'+pada+'"');
}
function appSettingsLoad(){
    var maintenance = loadData('maintenance');
    if (maintenance != 'clicked'){
        $("#modalmaintenance").removeClass("off");
        $("#modalmaintenance").addClass("on");
    }
    var appPremium = loadData('premium');
    //console.log(maintenance);
    console.log('Settings Loaded');
}
function salinInput() {
    var copyText = document.getElementById("codeinput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
}
function getPesan(content){
    $("#modalpesan .modal-content p").html(content);
    $("#modalpesan").removeClass("off");
    $("#modalpesan").addClass("on");
};
$(document).on('click','.toggle',function(e){
    var idnya = $(this).attr("toggle");
    var has = $("#"+idnya).hasClass('on');         
    if (has == true){
        $("#"+idnya).addClass("off");
        $("#"+idnya).removeClass("on");
        //console.log('off');
        setData('clicked','maintenance');
    }else{
        $("#"+idnya).addClass("on");
        $("#"+idnya).removeClass("off");
        //console.log('on');  
    }
});