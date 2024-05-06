document.addEventListener("DOMContentLoaded", function () {
  /********************déclaration des variables *****************************/
  let taskForm = document.getElementById("taskForm");
  let taskInputEl = document.getElementById("taskInput");
  let taskList = document.getElementById("taskList");

  /******************** vérification coté serveur ******************************/

  taskForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Empêcher la soumission par défaut du formulaire
    let taskInput = taskInputEl.value.trim(); // Obtenir la valeur l'entrée

    if (taskInput.length < 5) {
      alert("Task should be at least 5 characters");
      console.log("should be at least 5 characters");
      return;
    }

    // alert("Form submitted successfully");
    addTaskToDB(taskInput);
  });

  /********************** addTask() -> to DB ************************************/
  async function addTaskToDB(taskInput) {
    try {
      const response = await fetch("task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          add_task: "add",
          content_task: taskInput,
        }),
      });
      if (!response.ok) {
        throw new Error("Failed to add task to Database");
      }
      let taskData = await response.json();
      addTaskToList(taskData.id, taskInput);
      taskInputEl.value = "";
      taskInputEl.focus();
    } catch (error) {
      console.error("Erro : ", error);
    }
  }

  /*****************addTaskToList() -> to DOM **************/
  function addTaskToList(taskId, taskInput) {
    //créer un élément liste
    let taskItem = document.createElement("li");
    taskItem.className =
      "list-group-item d-flex justify-content-between align-items-center";
    taskItem.dataset.taskId = taskId;
    taskItem.innerHTML = `
    <span>${taskInput}</span>
    <button class="btn btn-danger btn-sm delete-btn" name="delete_Task">Delete</button>
  `;
    //ajouter l'élément à la liste DOM
    taskList.appendChild(taskItem);
  }

  /**
   * Ajoute un gestionnaire d'évènement pour le bouton de suppression
   */

  taskList.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-btn")) {
      let taskItem = e.target.parentElement;
      let taskId = taskItem.dataset.taskId;
      deleteTaskDBandDOM(taskItem, taskId);
      alert("Are you sure ?");
    }
  });

  /**************deleteTask() -> from BD and In DOM **************/
  async function deleteTaskDBandDOM(taskItem, taskId) {
    try {
      const response = await fetch("task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          delete_task: "delete",
          task_id: taskId,
        }),
      }); //.then(console.log("OK DELETE SEREVEUR"));

      if (!response.ok) {
        throw new Error("Failed to delete task from Database");
      }

      taskItem.remove();
    } catch (error) {
      console.error("Error :", error);
    }
  }

  /************** fetch and displays tasks -> from BD **************/
  async function fetchAndDisplayTasks() {
    try {
      const response = await fetch("task.php", {
        method: "GET",
      });

      if (!response.ok) {
        throw new Error("Failed to fetch tasks");
      }
      const data = await response.json(); //convertir la réponse en json
      displayTasks(data);
    } catch (error) {
      console.error("Erro : ", error);
    }
  }

  /*********** displayTasks() -> display tasks fetches from DB ************/
  function displayTasks(data) {
    //vider la liste existante
    taskList.innerHTML = "";

    //ajouter les nouvelles tâches à la liste
    data.forEach((element) => {
      addTaskToList(element.id, element.task_content);
    });
  }

  /******************** RefreshTasks every 5 seconds ***********/
  function RefreshTasks() {
    setInterval(fetchAndDisplayTasks, 5000); //rafraichis toutes les 5s
  }

  /**************************** SUIVI ******************************/
  // Appel initial pour récupérer et afficher les tâches lors du chargement de la page
  fetchAndDisplayTasks();

  //Appel pour rafraîchir périodiquement les tâches
  RefreshTasks();
});
