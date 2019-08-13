<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><?php echo getSettings("Title"); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?page=characters"><?php echo icon("person", default, default, true); ?> Characters</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=players"><?php echo icon("player", default, default, true); ?> Players</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=alliances"><?php echo icon("alliance", default, default, true); ?> Alliances</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=bans"><?php echo icon("bans", default, default, true); ?> Bans</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=logs"><?php echo icon("terminal", default, default, true); ?> Logs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=serverquery"><?php echo icon("steam", default, default, true); ?> ServerQuery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=settings"><?php echo icon("settings", default, default, true); ?> Settings</a>
      </li>
    </ul>
  </div>
</nav>
<br>
