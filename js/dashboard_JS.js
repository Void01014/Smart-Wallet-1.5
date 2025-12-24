const graph = document.getElementById('graph').getContext('2d');

new Chart(graph, {
    type: 'line',
    data:{
        labels: Array.from({ length: 31 }, (_, i) => i + 1),
        datasets: [{
            label:'Income',
            data: inc_amounts,
            backgroundColor: 'rgba(0, 180, 250, 0.45)',
            borderColor:'rgba(0, 150, 250, 0.9)',
            borderWidth:1,
            fill:true
        },
        {
            label:'expense',
            data: exp_amounts,
            backgroundColor: 'rgba(250, 0, 0, 0.45)',
            borderColor:'red',
            borderWidth:1,
            fill:true
        }]
    }
});

const rows = document.querySelectorAll('.rows');

rows.forEach(element => {
    element.insertAdjacentHTML('beforeend', `<td class="w-9 rounded-lg overflow-hidden bg-green-400 cursor-pointer edit"><img src="img/edit_icon.png"></tr>`);
    element.insertAdjacentHTML('beforeend', `<td class="w-5 rounded-lg overflow-hidden"><button class= "bg-red-500 p-2 cursor-pointer delete">x</button></tr>`);
});

document.querySelectorAll('.edit').forEach(button => {
    button.addEventListener('click', async() => {
        const row = button.closest('.rows');
        
        console.log(row);
        
        const typeCell = row.querySelector('.type');
        const amountCell = row.querySelector('.amount');
        const descCell = row.querySelector('.desc');
        const dateCell = row.querySelector('.date');

         if (!row.dataset.editing) {
            // ▶️ ENTER EDIT MODE
            row.dataset.editing ="true" 


            
            const typeValue = typeCell.textContent.trim();
            const amountValue = amountCell.textContent.replace('Dh', '').trim();
            const descValue = descCell.textContent.trim();
            const dateValue = dateCell.textContent.trim();

            typeCell.innerHTML = `<input type="text" value="${typeValue}" class="edit-type rounded-lg p-1 editable">`;
            amountCell.innerHTML = `<input type="number" value="${amountValue}" class="edit-amount rounded-lg p-1 editable">`;
            descCell.innerHTML = `<input type="text" value="${descValue}" class="edit-desc rounded-lg p-1 editable">`;
            dateCell.innerHTML = `<input type="date" value="${dateValue}" class="edit-date rounded-lg p-1 editable">`;

            // Optional: change button text (still same style)
        } else {

            const id = row.id;
            const mode = row.dataset.mode;        
            const newType = typeCell.querySelector('input').value;
            const newAmount = amountCell.querySelector('input').value;
            const newDesc = descCell.querySelector('input').value;
            const newDate = dateCell.querySelector('input').value;

            typeCell.textContent = newType;
            amountCell.textContent = newAmount +" Dh";
            descCell.textContent = newDesc;
            dateCell.textContent = newDate;

            delete row.dataset.editing;

            try {
                const response = await fetch('edit_row.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&mode=${mode}&type=${newType}&amount=${newAmount}&description=${newDesc}&date=${newDate}`
                });

                const result = await response.json();

                if(result.success){
                    console.log("nice");
                } else {
                    alert('Failed to delete row.');
                }
                } catch (err) {
                console.error('Error deleting row:', err);
                }

            // console.log("READY TO SEND:", {
            //     newType,
            //     newAmount,
            //     newDesc,
            //     newDate
            // });
        }
    });

});

document.querySelectorAll('.delete').forEach(element => {
    element.addEventListener('click', async(event) => {
        const row = element.closest('.rows');
        const id = row.id;
        const mode = row.dataset.mode;        

         try {
            const response = await fetch('delete_row.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&mode=${mode}`
            });

            const result = await response.json();

            if(result.success){
                row.remove();
            } else {
                alert('Failed to delete row.');
            }
            } catch (err) {
            console.error('Error deleting row:', err);
        }
    })
});