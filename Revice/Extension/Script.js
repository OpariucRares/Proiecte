async function fetchData() {
    const res=await fetch ("http://localhost/PHP/Controller/ProductController.php?Method=getRandomProducts&params=Laptop");
    const record=await res.json();
    let table = document.createElement('table');
    table.setAttribute("witdh","100%");
    let thead = document.createElement('thead');
    let tbody = document.createElement('tbody');

    table.appendChild(thead);
    table.appendChild(tbody);

    // Adding the entire table to the body tag
    document.getElementById('body').appendChild(table);


    let row_1 = document.createElement('tr');
let heading_1 = document.createElement('th');
heading_1.innerHTML = "Nume";
heading_1.setAttribute("width","100%");
heading_1.setAttribute("margin-bottom","50px");
let heading_2 = document.createElement('th');
heading_2.innerHTML = "Tip";
let heading_3 = document.createElement('th');
heading_3.innerHTML = "Pret";
let heading_4 = document.createElement('th');
heading_4.innerHTML = "Magazin";

row_1.appendChild(heading_1);
row_1.appendChild(heading_2);
row_1.appendChild(heading_3);
row_1.appendChild(heading_4);
thead.appendChild(row_1);



    for(const item of record){
        let row_2 = document.createElement('tr');
        let row_2_data_1 = document.createElement('td');
        row_2_data_1.innerHTML = item.name.split(',')[0];
        row_2_data_1.setAttribute("witdh","100px");
        let row_2_data_2 = document.createElement('td');
        row_2_data_2.innerHTML = item.type;
        let row_2_data_3 = document.createElement('td');
        row_2_data_3.innerHTML = item.price;
        let row_2_data_4 = document.createElement('td');
        row_2_data_4.innerHTML = item.rating;

        row_2.appendChild(row_2_data_1);
        row_2.appendChild(row_2_data_2);
        row_2.appendChild(row_2_data_3);
        row_2.appendChild(row_2_data_4);
        tbody.appendChild(row_2);
    }
}
fetchData();