<?php
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>PCOS</title>
		<link rel="stylesheet" href="../css/topnav.css" type="text/css">
		<link rel="stylesheet" href="../css/background.css" type="text/css">
		<link rel="stylesheet" href="../css/card.css" type="text/css">
		<link rel="stylesheet" href="../css/click.css" type="text/css">
		<style type="text/css">
			body{	
					padding:2vh 4vw 2vh 4vw;
			}
			.card{
				padding:0.1vh 2vw 2vh 2vw;
				margin-bottom:2vh;
			}
			.click{
				background-image:linear-gradient(to right,#7CFC00,#7CFC00);
			}
			div>div{
				cursor:pointer;
			}
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<span class="close" style="cursor:pointer" onclick="document.location.href='../menu.html'"><b>X</b></span>
		</div>
_END;
if(isset($_POST['skin_darkening']))
{
	$features = ['skin_darkening','hair_growth','weight_gain','cycle_regular','fast_food','acne','hair_loss',
				'amh','exercise','vitaminD3','age','weight','lh','bmi','hips','waist','marriage_status','period_length',
				'abortions','fsh'
				];
				
	for($i=0 ; $i<sizeof($features) ; $i++)
	{
		$input .= $_POST[$features[$i]].',';
	}	
	$input = rtrim($input,',');
	$command = "powershell -command \"C:\anaconda3\python 'C:\Program Files\Ampps\www\menses\pcos\predict.py' '$input'\"2>&1";
	//shell_exec opens cmd. Hence we run powershell command in cmd. We have already set conda environment in powershell using commands present in script.ps1
	$result =shell_exec($command);
	echo <<<_END
		<div class="card">
		$result
		</div>
_END;
}
else
	echo <<<_END
		<form method="post" action="pcos.php">
		<div class='card'>
			Do you have any skin darkening ? 
			<input type="radio" name="skin_darkening" value="1" required>Yes
			<input type="radio" name="skin_darkening" value="0">No
		</div>
		<div class='card'>
			Do you have excessive facial hair growth ?
			<input type="radio" name="hair_growth" value="1" required>Yes
			<input type="radio" name="hair_growth" value="0">No
		</div>
		<div class='card'>
			Have you gained any weight ?
			<input type="radio" name="weight_gain" value="1" required>Yes
			<input type="radio" name="weight_gain" value="0">No
		</div>
		<div class='card'>
			Is you cycle regular ?
			<input type="radio" name="cycle_regular" value="2" required>Yes
			<input type="radio" name="cycle_regular" value="4">No
		</div>
		<div class='card'>
			Do you eat fast food ?
			<input type="radio" name="fast_food" value="1" required>Yes
			<input type="radio" name="fast_food" value="0">No
		</div>
		<div class='card'>
			Do you have excessive acne ?
			<input type="radio" name="acne" value="1" required>Yes
			<input type="radio" name="acne" value="0">No
		</div>
		<div class='card'>
			Do have hair loss?
			<input type="radio" name="hair_loss" value="1" required>Yes
			<input type="radio" name="hair_loss" value="0">No
		</div>
		<div class='card'>
			What are you AMH(anti-mullerian hormone) levels in (ng/ml) ?
			<input type="number" name="amh" min="0" step="any" required>
		</div>
		<div class='card'>
			Do you exercise regularly ?
			<input type="radio" name="exercise" value="1" required>Yes
			<input type="radio" name="exercise" value="0">No
		</div>
		<div class='card'>
			What are your Vitamin D3 levels in (ng/ml) ?  <!nanogram/milliliter>
			<input type="number" name="vitaminD3" min="0" step="any" required>
		</div>
		<div class='card'>
			What is your age in (yrs) ?
			<input type="number" name="age" min="1" required>
		</div>
		<div class='card'>
			What is your weight in (kgs) ?
			<input type="number" name="weight" min="0" step="any" required>
		</div>
		<div class='card'>
			What are your LH(luteinizing hormone) levels in (mIU/ml) ? <!milli-international units/milliliter>
			<input type="number" name="lh" min="0" step="any" required>
		</div>
		<div class='card'>
			What is your BMI ?
			<input type="number" name="bmi" min="0" step="any" required>
		</div>
		<div class='card'>
			What is the measurement of your hips in (inches) ?
			<input type="number" name="hips" min="1" step="any" required>
		</div>
		<div class='card'>
			What is your waist size in (inches) ?
			<input type="number" name="waist" min="1" step="any" required>
		</div>
		<div class='card'>
			What is your marriage status in (yrs) ?
			<input type="number" name="marriage_status" min="0" step="any" required>
		</div>
		<div class='card'>
			What is your period length in (days) ?
			<input type="number" name="period_length" min="1" id="pl" required><br>
			<Span class="click" onclick="set_pl()">Add my period length</span>
		</div>
		<div class='card'>
			How many abortions have you had ?
			<input type="number" name="abortions" min="0" required>
		</div>
		<div class="card">
			What are your FSH(follicle-stimulating hormone) levels in (mIU/ml) ?
			<input type="number" name="fsh" min="0" step="any" required>
		</div>
		<div class="card">
			<input type="submit"  value="Predict PCOS Probability">
		</div> 
		</form>
_END;
echo <<<_END
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript" src="../js/dates.js"></script>
	<script type="text/javascript">
	
	//function for adding users period day if button clicked
		function set_pl()
		{
			document.getElementById('pl').setAttribute("value",pl);   //pl already defined in dates.js
		}
	</script>
	</html>
_END;
?>