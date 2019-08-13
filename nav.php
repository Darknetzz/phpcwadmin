<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><?php echo getSettings("Title"); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?page=characters"><?php echo icon("person"); ?> Characters</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=players"><?php echo icon("player"); ?> Players</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=alliances"><?php echo icon("alliance"); ?> Alliances</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=bans"><?php echo icon("bans"); ?> Bans</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=logs"><?php echo icon("terminal"); ?> Logs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=serverquery"><?php echo icon("steam"); ?> ServerQuery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=settings"><?php echo icon("settings"); ?> Settings</a>
      </li>
    </ul>
  </div>
</nav>
<br>
