<?php

/**
 * @var $errorTitle
 * @var $errorMessage
 */

$numberOfSquares = 30;

?>

<style>
    .site-error {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 3%, rgba(60, 60, 60, 0.5382528011204482) 36%, rgba(0, 212, 255, 1) 100%);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .site-error span {
        position: absolute;
        display: block;
        list-style: none;
        animation: animate 10s linear infinite;
        bottom: -150px;
    }

    @keyframes animate {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
            border-radius: 0;
        }
        100% {
            transform: translateY(-1000px) rotate(720deg);
            opacity: 0;
            border-radius: 50%;
        }
    }
</style>

<div class="site-error">
    <div style="position: absolute; top: 10%; width: 100%">
        <h1 style="color: white;"><?php echo $errorTitle ?? 'Bad Request'; ?></h1>

        <div class="row justify-content-start">
            <div class="col-lg-12">
                <div class="alert alert-danger" style="text-align: center;">
                    <b><?php echo $errorMessage ?? 'Ups! Something went wrong'; ?></b>
                </div>
            </div>
        </div>
    </div>

    <?php for ($i = 1; $i <= $numberOfSquares; $i++) { ?>
        <span></span>
    <?php } ?>
</div>

<script src="../../web/js/jquery.min.js"></script>
<script>
    let numberOfSquares = '<?php echo $numberOfSquares; ?>'

    $(document).ready(function() {
        getFloatingUpRandomSquaresBackground(numberOfSquares)

        squareBlow()
    })

    /**
     * Get multiple floating up squares background
     * @param numberOfSquares
     */
    function getFloatingUpRandomSquaresBackground(numberOfSquares) {
        let attributes = {
            'width': {
                'min': 10,
                'max': 150,
                'measureUnit': 'px',
                'paramsWithSameValue': 'height'
            },
            'left': {
                'min': 1,
                'max': 100,
                'measureUnit': '%'
            },
            'animation-delay': {
                'min': 0,
                'max': 10,
                'measureUnit': 's'
            },
            'background-color': {
                'possibleValues': {
                    0: 'rgba(175, 0, 0, 0.3)',
                    1: 'rgba(0, 175, 0, 0.3)',
                    2: 'rgba(0, 0, 175, 0.3)'
                },
                'measureUnit': ''
            }
        }

        for (let i = 0; i < numberOfSquares; i++) {
            let square = $(".site-error span:nth-child(" + i + ")")

            $.each(attributes, function (key, value) {
                let randomValue

                if (value.possibleValues !== undefined) {
                    let randomIndex = Math.floor(Math.random() * Object.keys(value.possibleValues).length);
                    randomValue = value.possibleValues[randomIndex]
                } else {
                    randomValue = Math.floor(Math.random() * (value.max - value.min + 1)) + value.min
                    if (value.paramsWithSameValue !== undefined) {
                        let params = value.paramsWithSameValue.split(',')

                        for (let x in params) {
                            square.css(params[x], randomValue + value.measureUnit);
                        }
                    }
                }

                square.css(key, randomValue + value.measureUnit);
            });
        }
    }

    /**
     * Remove squares when clicked
     */
    function squareBlow() {
        $('.site-error').children('span').on("click", function () {
            $(this).remove()
        })
    }
</script>
