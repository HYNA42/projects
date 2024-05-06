<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestionnaire de Tâches</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body class="bg-dark text-white">
  <div class="container">
    <h1 class="text-center mt-5">To Do - List</h1>
    <!-- Form for adding tasks -->
    <form id="taskForm" action="task.php" method="post" class="mt-4">
      <div class="mb-3">
        <label for="taskInput" class="form-label">Ajouter une nouvelle tâche</label>
        <input type="text" class="form-control" id="taskInput" name="content_task" placeholder="Entrez votre tâche ici..." />
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- Task list -->
    <ul id="taskList" class="list-group mt-3">
      <!-- Task items will be dynamically added here -->
    </ul>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="check.js" type="module"></script>
</body>

</html>