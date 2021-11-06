function checkExpert(category, parentid = "ParentId"){
    if(category == "expert"){
        return document.getElementById(parentid).style.display = "block";
    }
    else{
        return document.getElementById(parentid).style.display = "none";
    }
    
}