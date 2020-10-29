function makeRequest(method, url) {
    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url);
        xhr.onload = function () {
            if (this.status >= 200 && this.status < 300) {
                resolve(xhr.response);
            } else {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.onerror = function () {
            reject({
                status: this.status,
                statusText: xhr.statusText
            });
        };
        xhr.send();
    });
}


async function requestDataPersonal() {    
    let result = await makeRequest("GET", '/survey/hasil/getpersonal');    
    result = JSON.parse(result);    
    var data_personal = result.hasil_survey;
    // console.log(data_personal.hasil_survey);

    // create an array with nodes
    var position_x = [120, 230, 225, 215, 300, 300, 300, 385];
    var position_y = [155, 100, 165, 220, 220, 165, 100, 155];

    var nodes = new vis.DataSet();

    for(var i = 0; i < data_personal.length; i++){
        var counter = i+1;
        // console.log(data_personal[i].dimensi);
        switch (data_personal[i].dimensi) {
            case "risk":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[0], y: position_y[0]}]);
                break;
            case "organizationallearning":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[1], y: position_y[1]}]);
                break;
            case "commitment":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[2], y: position_y[2]}]);
                break;
            case "leadership":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[3], y: position_y[3]}]);
                break;
            case "competence":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[6], y: position_y[6]}]);
                break;
            case "responsibility":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[5], y: position_y[5]}]);
                break;
            case "engagement":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[4], y: position_y[4]}]);
                break;
            case "informationcommunication":
                var id_label = String(counter);
                nodes.add([{id: id_label, label: id_label, x: position_x[7], y: position_y[7]}]);
                break;        
        }
    }

    // create an array with edges
    var edges = new vis.DataSet([
        {from: 1, to: 2},
        {from: 2, to: 3}, 
        {from: 3, to: 4},
        {from: 4, to: 5},
        {from: 5, to: 6},
        {from: 6, to: 7},
        {from: 7, to: 8},               
    ]);

    // create a network
    var container = document.getElementById('mynetwork');

    // provide the data in the vis format
    var data = {
        nodes: nodes,
        edges: edges
    };

    var width = 400;
    var height = 600;
    var options = {
        width: width + 'px',
        height: height + 'px',
        interaction:{
            keyboard: false,
            zoomView: false,
            dragView: false,
            dragNodes: false
        },
        physics:{
            enabled: false
        },
        nodes:{
            fixed:{
                x: true,
                y: true
            },
            shape: 'circle'
        },
        edges:{
            arrows: {
                to: {
                    enabled: true,
                }
            }
        }
    };

    // initialize your network!
    var network = new vis.Network(container, data, options);
    network.moveTo({
        position: {x: 0, y: 0},
        offset: {x: -width/2, y: -height/2},
        scale: 1,
    })
}

requestDataPersonal();