<?php
    include_once('helpers/check_registers.php');
    $niveles = $cur_sem->getLevels($curso_seminario['codigo']);
    include_once('includes/preloader.php');
?>

<section class="courses-section ver-section text-center px-3">
    <div class="head-title background-overlay"
        style="
            background-image:url(/plataforma/img/cursos/<?php echo $curso_seminario['imagen'] ?>);
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            padding: 2rem 0;
        ">
            <h4 class="text-white title text-center my-4"><?php echo $curso_seminario['nombre'] ?></h4>
    </div>
    <div class="courses-container">
        <div class="levels-box">
            <div class="progress my-2">
                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <?php $countLevel = 1;
                foreach($niveles as $nivel) : ?>
                <div class="level-tab accordeon-tab" data-target="level-<?php echo $countLevel; ?>">
                    <p class="title"><?php echo $nivel['nombre'] ?></p>
                    <i class="fas level-<?php echo $countLevel ?> fa-chevron-down fa-2x" style="transition: all .3s ease-in-out"></i>
                </div>
                    <div id="level-<?php echo $countLevel ?>" class="level-<?php echo $countLevel ?> level-content">
                        <div class="lessons-box px-3 d-flex flex-wrap">
                            <?php
                                $countLesson = 1;
                                $lecciones = $cur_sem->getLevelLessons($nivel['codigo']);

                                foreach($lecciones as $leccion) :
                            ?>
                            <div class="lesson-tab accordeon-tab btn btn-block text-justify col-11" data-target="lesson-<?php echo $countLesson; ?>">
                                <a href="#" class="text-capitalize"><?php echo ($leccion['nombre']) ?></a>
                                <i class="fas lesson-<?php echo $countLesson; ?> fa-chevron-down" style="transition: all .3s ease-in-out"></i>
                            </div>
                                <input class="form-element" type="checkbox">
                                <div id="lesson-<?php echo $countLesson; ?>" class="lesson-<?php echo $countLesson; ?> my-4 lesson-content col-12">
                                    <?php 
                                        $videos = $cur_sem->getLessonVideos($leccion['codigo']);
                                        foreach ($videos as $video) :
                                    ?>
                                            <iframe src="https://player.vimeo.com/video/<?php echo $video['src'] ?>" style="max-width:100%;" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="<?php echo $curso_seminario['nombre'] ?>"></iframe>
                                        <?php endforeach; ?>
                                </div>
                            <?php 
                                $countLesson++;
                                endforeach;     
                            ?>
                        </div>
                    </div>
            <?php 
                $countLevel++;
                endforeach; 
            ?>
        </div>
    </div>
</section>