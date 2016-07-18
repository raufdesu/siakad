$(document).ready(function(){

});
function multiReplace(str, match, repl) {
	do {
		str = str.replace(match, repl);
	} while(str.indexOf(match) !== -1);
	return str;
}
function replaceMasal(string){
	var newString1 = multiReplace(string,' ','--tandaspasi--');
	var newString2 = multiReplace(newString1,'%','--tandapersen--');
	var newString3 = multiReplace(newString2,"'",'--petiksatu--');
	var newString4 = multiReplace(newString3,",",'--tandakoma--');
	var newString5 = multiReplace(newString4,"&",'--tandadan--');
	var newString6 = multiReplace(newString5,"?",'--tandatanya--');
	var newString7 = multiReplace(newString6,"(",'--kurungbuka--');
	var newString8 = multiReplace(newString7,")",'--kurungtutup--');
	var newString9 = multiReplace(newString8,"$",'--dolar--');
	var newString10 = multiReplace(newString9,"@",'--tandaet--');
	var newString11 = multiReplace(newString10,"#",'--tandakres--');
	var newString12 = multiReplace(newString11,"+",'--tandatambah--');
	var newString13 = multiReplace(newString12,"/",'--tandaslash--');
	return newString13;
}
function doInteger(nilaiAwal){
	var newString1 = multiReplace(nilaiAwal,' ','');
	var newString2 = multiReplace(newString1,'.','');
	return newString2;
}
function switch_tab(obj)
{
    $(".tabs > a").attr("class", "tab");
    $(obj).attr("class", "current_tab");
}
function formatNumber(input)
{
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('You may only enter two decimals!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
    }
    else{ alert('Anda hanya diperbolehkan memasukkan angka!');
    input.value = input.value.substring(0,input.value.length-1);
    }
}


/* COMMON FUNCTIONS */
function load(page,div){
	do_scroll(0);
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: site+"/"+page,
        beforeSend: function(){
            $(div).html(image_load);
        },
        success: function(response){
            $(div).html(response);
        },
        dataType:"html"  		
    });
    return false;
}
function send_form_loading(formObj,action,responseDIV)
{
    var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
    $.ajax({
        url: site+"/"+action, 
        data: $(formObj.elements).serialize(),
        beforeSend: function(){
            $(responseDIV).html(image_load);
        },
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post", 
        dataType: "html"
    }); 
    return false;
}
function load_small(page,div,loadingDom,opt){
    var image_load_small = "<span class='ajax_loading_small'><img src='"+loading_image_small+"' /></span>";
    $.ajax({
        url: site+"/"+page,
        beforeSend: function(){
            $(loadingDom).html(image_load_small);
        },
        success: function(response){
            $(loadingDom).html('');
            if(opt=="append")
            {
                $(div).append(response);
            }
            else
            {
                $(div).html(response);
            }
        },
        dataType:"html"  		
    });
    return false;
}
function load_no_loading(page,div){
    $.ajax({
        url: site+"/"+page,
        success: function(response){
            $(div).html(response);
        },
        dataType:"html"  		
    });
    return false;
}
function dummyload(page){
    $.ajax({
        url: site+"/"+page,
        dataType:"html"  		
    });
    return false;
}
function load_into_box(page,dt){
    $.ajax({
        url: site+"/"+page,
        data: dt,
        success: function(response){			
            jQuery.facebox(response);
        },
        type:"post",
        dataType:"html"  		
    });
    return false;
}
function send_form(formObj,action,responseDIV)
{
    $.ajax({
        url: site+"/"+action, 
        data: $(formObj.elements).serialize(), 
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post", 
        dataType: "html"
    }); 
    return false;
}
function do_scroll(point)
{
	$('html').animate({
		scrollTop: point
	}, 500);
}