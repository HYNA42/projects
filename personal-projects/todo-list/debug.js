document.addEventListener("DOMContentLoaded", function () {
  let taskForm = document.getElementById("taskForm");
  let taskInputEl = document.getElementById("taskInput");
  let taskList = document.getElementById("taskList");

  taskForm.addEventListener("submit", function (e) {
    e.preventDefault();

    let taskInput = taskInputEl.value.trim();

    if (taskInput.length < 5) {
      alert("Password should be at least 5 characters");
      console.log("should be at least 5 characters");
      return;
    }

    addTaskToDB(taskInput);
  });

  async function addTaskToDB(taskInput) {
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
      console.error("Failed to add task");
      return;
    }

    const taskData = await response.json();
    addTaskToList(taskData.id, taskInput);
    taskInputEl.value = "";
    taskInputEl.focus();
  }

  function addTaskToList(taskId, taskInput) {
    let taskItem = document.createElement("li");
    taskItem.className =
      "list-group-item d-flex justify-content-between align-items-center";
    taskItem.dataset.taskId = taskId;
    taskItem.innerHTML = `
      <span>${taskInput}</span>
      <button class="btn btn-danger btn-sm delete-btn" name="delete_Task">Delete</button>
    `;
    taskList.appendChild(taskItem);
  }

  taskList.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-btn")) {
      let taskItem = e.target.parentElement;
      let taskId = taskItem.dataset.taskId;

      deleteTaskDBandDOM(taskItem, taskId);
      alert("Are you sure ?");
    }
  });

  async function deleteTaskDBandDOM(taskItem, taskId) {
    const response = await fetch("task.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        delete_task: "delete",
        task_id: taskId,
      }),
    });

    if (!response.ok) {
      console.error("Failed to delete task");
      return;
    }

    taskItem.remove();
  }
});
