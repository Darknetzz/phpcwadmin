<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><?php echo getSettings("Title"); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?page=characters"><?php echo icon("person", "svg", 15, true); ?> Characters</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=players"><?php echo icon("player", "svg", 15, true); ?> Players</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=alliances"><?php echo icon("alliance", "svg", 15, true); ?> Alliances</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=bans"><?php echo icon("bans", "svg", 15, true); ?> Bans</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=logs"><?php echo icon("terminal", "svg", 15, true); ?> Logs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=serverquery"><?php echo icon("steam", "svg", 15, true); ?> ServerQuery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=settings"><?php echo icon("settings", "svg", 15, true); ?> Settings</a>
      </li>
    </ul>
  </div>
</nav>
<br>
