<#this powershell script can be used to setup conda environment in powershell permanetly.
This was done because anaconda was used to create the ML model and conda environment needs to be activated 
before running any script.
Note that environment variables for conda need to be set prior to executing this script#>
powershell -ExecutionPolicy Bypass -NoExit -Command "& 'C:\anaconda3\shell\condabinconda-hook.ps1' ; conda activate 'C:\anaconda3'";
conda config --set auto_activate_base true;
conda init powershell;
