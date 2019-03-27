<?php if ($training): ?>
    <h2><?php echo $training["name"];?></h2>

    <?php if (isset($training['theme'])): ?>
        <div id="theme">
            <h3>Thème : </h3>
            <p><?php echo $training["theme"]["name"];?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($training['tags']) && count($training['tags']) > 0): ?>
        <div id="tags">
            <h3>Tags : </h3>
            <p>
                <?php foreach ($training["tags"] as $key => $tag) {
                    if ($key > 0) {
                        echo ", ";
                    }
                    echo $tag['name'];
                } ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if (isset($training['objectives']) && !empty($training["objectives"])): ?>
        <div id="objectives">
            <h3>Objectifs</h3>
            <p><?php echo $training["objectives"];?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($training['program']) && !empty($training["program"])): ?>
        <div id="program">
            <h3>Programme</h3>
            <p><?php echo $training["program"];?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($training['prerequisite']) && !empty($training["prerequisite"])): ?>
        <div id="prerequisite">
            <h3>Prérequis</h3>
            <p><?php echo $training["prerequisite"];?></p>
        </div>
    <?php endif; ?>

    <div id="publicType">
        <h3>Public concerné</h3>
        <?php if (isset($training["publicTypes"]) && count($training["publicTypes"]) > 0): ?>
            <p>
            <?php foreach ($training["publicTypes"] as $publicType): ?>
                <?php echo $publicType["name"] . ' ';?>
            <?php endforeach; ?>
            </p>
        <?php else: ?>
            <p>Tous publics URFIST</p>
        <?php endif; ?>
    </div>

    <?php if (isset($session)): ?>
        <?php if(isset($session["participations"]) && count($session["participations"]) > 0): ?>
            <div class="trainers">
                <?php if(count($session["participations"]) > 1): ?>
                    <h3> Formateurs: </h3>
                <?php else: ?>
                    <h3> Formateur: </h3>
                <?php endif; ?>
                <p>
                <?php
                $i = 0;
                foreach ($session["participations"] as $participation) {
                    echo ucwords($participation['trainer']["fullName"]);
                    $i++;
                    if ($i < count($session["participations"])) {
                        echo ' - ';
                    }
                } ?>
            </div>
        <?php endif; ?>

        <?php if(isset($session["scheduleString"]) || !empty($session["rooms"])): ?>
	        <div id="hourPlace">
	            <h3>Date et lieu</h3>
	            <p>
		            <?php echo isset($session["scheduleString"]) ? $session["scheduleString"] . '</br>' : null; ?>
		            <?php if (!empty($session["rooms"])) {
		            	  if (count($session["rooms"]) === 1) {
		            	  	echo '<p>Salle : ' . $session["rooms"][0]['name'] . '</p>';
			              }
		            	  else {
		            	  	echo '<p>Salles disponibles :</p><ul>';
			                foreach ($session["rooms"] as $room) {
				                echo '<li>' . $room['name'] . '</li>';
			                }
			                echo '</ul>';
	                  }
	                } ?>
	            </p>
	        </div>
        <?php endif; ?>

        <?php if (isset($session["price"]) && $session["price"] > 0): ?>
	        <div id="price">
		        <h3>Prix</h3>
		        <p><?php echo $session["price"]; ?> €</p>
	        </div>
        <?php endif; ?>

        <div id="sessions">
          <?php if (count($training["sessions"]) > 1): ?>
			        <h3>Prochaine(s) session(s)</h3>
          <?php else: ?>
			        <h3>Prochaine session</h3>
          <?php endif; ?>
	        <ul>
	        <?php foreach ($training["sessions"] as $session): ?>
				        <li>
					        <strong><?php echo (new \Datetime($session["dateBegin"]))->format("d/m/Y");?></strong>
					        <br />
				          <?php if (isset($session["schedule"]) && $session["schedule"]): ?>
					          <?php echo $session["schedule"]; ?>
									        <br />
				          <?php endif; ?>

				          <?php if (isset($session["place"]) && $session["place"]): ?>
					          <?php echo $session["place"]["name"]; ?>
									        <br />
				          <?php endif; ?>

				          <?php if ($session["availablePlaces"] > 0): ?>
									        <span>Disponible</span>
				          <?php else: ?>
									        <span>Complet</span>
				          <?php endif; ?>
				        </li>
	        <?php endforeach; ?>
	        </ul>
        </div><br/>

        <a title="S'inscrire au stage" href="<?php echo $session["publicUrl"];?>" target="_blank"><strong>S’inscrire</strong></a><br />
        <br/>
        <br/>
        <p><strong>Rappel : les stages sont gratuits pour tous les personnels d’établissements d’enseignement supérieur et de recherche, ainsi que pour les doctorants.</strong></p>
		<?php endif; ?>
	<?php else: ?>
	<h2>La formation demandée n'existe pas</h2>
<?php endif; ?>