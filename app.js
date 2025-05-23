document.addEventListener("DOMContentLoaded", ()=>{
    let tasks =[];

    const saveTasks =() => {
        fetch('save_tasks.php', {
            method: 'POST',
            headers: {
                    'Content-Type' : 'application/json',
            },
            body : JSON.stringify(tasks)
        }) .then(response => {
            if(!response.ok){
                throw new Error('Failed to save tasks');
            } return response.json();
        }) .then (data =>{
            console.log('Tasks saved successfully', data);
        }) .catch(error => {
            console.error('Error saving tasks:', error);
        });
        
    };

    const addTask = ()=> {
        const taskInput = document.getElementById('taskInput');
        const text = taskInput.value.trim();

        if(text){
            tasks.push({text: text, completed: false });
            taskInput.value= "";
            updateTasksList();
            updateStats();
            saveTasks();
        }
    };

    const toggleTaskComplete = (index) => {
        tasks[index].completed= !tasks[index].completed;
        updateTasksList();
        updateStats();
        saveTasks();
    };

    const deleteTask = (index) => {
        tasks.splice(index,1);
        updateTasksList();
        updateStats();
        saveTasks();
    };

    const editTask =(index) => {
        const taskInput = document.getElementById("taskInput");
        taskInput.value = tasks[index].text

        tasks.splice(index,1);
        updateTasksList();
        updateStats();
        saveTasks();
    };

    const updateStats  =() => {
        const completedTasks = tasks.filter((task) => task.completed).length;
        const totalTasks = tasks.length;
        const progress = (completedTasks / totalTasks) *100;
        const progressBar = document.getElementById("progress");

        progressBar.style.width = `${progress}%`;

        // document.getElementById("progress").style.width = `${progress}%`
        document.getElementById("numbers").innerText=`${completedTasks} / ${totalTasks}`;
    };

    const updateTasksList =() =>{
        const taskList = document.getElementById("task-list");
        taskList.innerHTML="";

        tasks.forEach( (task,index) =>{
            const listItem =document.createElement("li")

            listItem.innerHTML=`
                <div class="taskItem">
                    <div class="task ${task.completed ? "completed": ""}">
                        <input type="checkbox" class="checkbox" 
                            ${task.completed? "checked" : ""}
                        />
                        <p>${task.text}</p>
                    </div>
                    <div class="icons">
                        <img src="./img/edit.png" class="edit-icon"/>
                        <img src="./img/bin.png" class="delete-icon"/>
                    </div>
                </div>
            `;
        listItem.addEventListener("change", ()=> toggleTaskComplete(index));
        listItem.querySelector(".edit-icon").addEventListener("click", () => editTask(index));
        listItem.querySelector(".delete-icon").addEventListener("click", () => deleteTask(index));
            taskList.append(listItem);
        });
    };

    document.getElementById("newTask").addEventListener("click", function(e){
        e.preventDefault();
        addTask();
    });

    fetch('load_tasks.php')
        .then(res => res.json())
        .then (data => {
            tasks = data;
            updateTasksList();
            updateStats();
        });
});
