async function saveSolutionById(solution_id) {
    var details = {
        'solution_id': solution_id,        
        '_token': document.querySelector('meta[name="csrf-token"]').content
    };
    
    var formBody = [];
    for (var property in details) {
      var encodedKey = encodeURIComponent(property);
      var encodedValue = encodeURIComponent(details[property]);
      formBody.push(encodedKey + "=" + encodedValue);
    }
    formBody = formBody.join("&");


    // Default options are marked with *
    const response = await fetch("/survey/solusi/save", {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'no-cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
        //   'Content-Type': 'application/json'
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/x-www-form-urlencoded',        
        },
        // redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: formBody // body data type must match "Content-Type" header
    });

    if (!response.ok) {
        const message = `An error has occured: ${response.status}`;
        // throw new Error(message);
        return document.getElementById('AlertErrorJs').innerHTML = new Error(message);
    }
    
    const respjson = await response.json();
    console.log(respjson);
    if(respjson.success){
        document.getElementById('AlertSuccessJs').style.display = "block";
        document.getElementById('ButtonImport' + solution_id).innerHTML = '<button class="btn btn-warning" onclick="deleteSolutionById('+solution_id+')">Cancel</button>';
        return document.getElementById('AlertSuccessJs').innerHTML = respjson.success;
    }
    else if(respjson.error){
        document.getElementById('AlertErrorJs').style.display = "block";
        return document.getElementById('AlertErrorJs').innerHTML = respjson.error;
    }
    // return response.json(); // parses JSON response into native JavaScript objects
}

async function deleteSolutionById(solution_id) {
    var details = {
        'solution_id': solution_id,        
        '_token': document.querySelector('meta[name="csrf-token"]').content
    };
    
    var formBody = [];
    for (var property in details) {
      var encodedKey = encodeURIComponent(property);
      var encodedValue = encodeURIComponent(details[property]);
      formBody.push(encodedKey + "=" + encodedValue);
    }
    formBody = formBody.join("&");


    // Default options are marked with *
    const response = await fetch("/survey/solusi/delete", {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'no-cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
        //   'Content-Type': 'application/json'
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/x-www-form-urlencoded',        
        },
        // redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: formBody // body data type must match "Content-Type" header
    });

    if (!response.ok) {
        const message = `An error has occured: ${response.status}`;
        // throw new Error(message);
        return document.getElementById('AlertErrorJs').innerHTML = new Error(message);
    }
    
    const respjson = await response.json();
    console.log(respjson);
    if(respjson.success){
        document.getElementById('AlertSuccessJs').style.display = "block";
        document.getElementById('ButtonImport' + solution_id).innerHTML = '<button class="btn btn-success" onclick="saveSolutionById('+solution_id+')">Select</button>';
        return document.getElementById('AlertSuccessJs').innerHTML = respjson.success;
    }
    else if(respjson.error){
        document.getElementById('AlertErrorJs').style.display = "block";
        return document.getElementById('AlertErrorJs').innerHTML = respjson.error;
    }
    // return response.json(); // parses JSON response into native JavaScript objects
}