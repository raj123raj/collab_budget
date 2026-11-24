
pipeline {
    agent any

<<<<<<< HEAD
    triggers {
        // Poll Git every 5 minutes; or configure a GitHub webhook instead
        pollSCM('H * * * *')
=======
    environment {
        PHP_EXE = 'D:\\Priya\\softwares\\php\\php.exe'
        DEPLOY_DIR = 'D:\\Xampp1\\htdocs\\collab-budget'
>>>>>>> e00c5fa24601ee82d841fa280560230020e79fdb
    }

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/raj123raj/collab_budget.git'
            }
        }

        stage('PHP Syntax Check') {
            steps {
                bat '''
                    echo Checking PHP installation...
                    "%PHP_EXE%" -v

                    echo Checking PHP files...

                    for /R %%f in (*.php) do (
                        "%PHP_EXE%" -l "%%f"
                        if errorlevel 1 exit /b 1
                    )

                    echo PHP syntax check completed successfully.
                '''
            }
        }

        stage('Deploy to XAMPP') {
            steps {
                bat '''
<<<<<<< HEAD
                  rem Get workspace and trim any trailing spaces
                  set "TMP=%WORKSPACE%"
                  for /f "tokens=* delims= " %%A in ("%TMP%") do set "SRC=%%A"
        
                  set "DEST=D:\\Xampp1\\htdocs\\collab-budget"
        
                  if not exist "%DEST%" (
                    mkdir "%DEST%"
                  )
        
                  echo SRC=[%SRC%]
                  echo DEST=[%DEST%]
        
                  robocopy "%SRC%" "%DEST%" /MIR /XD ".git" ".github" "sql" /XF ".gitignore"
        
                  set RC=%ERRORLEVEL%
                  echo Robocopy exit code: %RC%
                
                  if %RC% GEQ 8 (
                      echo Robocopy failed with exit code %RC%
                      exit /b %RC%
                 )
                
                 rem For 0–7, treat as success for Jenkins
                 exit /b 0
=======
                    set "SRC=%WORKSPACE%"
                    set "DEST=%DEPLOY_DIR%"

                    if not exist "%DEST%" (
                        mkdir "%DEST%"
                    )

                    echo Source: %SRC%
                    echo Destination: %DEST%

                    robocopy "%SRC%" "%DEST%" /E /R:2 /W:5 ^
                        /XD ".git" ".github" "sql" "node_modules" ^
                        /XF ".gitignore" "Jenkinsfile" ".env"

                    set "RC=%ERRORLEVEL%"

                    echo Robocopy exit code: %RC%

                    if %RC% GEQ 8 (
                        echo Deployment failed.
                        exit /b %RC%
                    )

                    echo Deployment completed successfully.
                    exit /b 0
>>>>>>> e00c5fa24601ee82d841fa280560230020e79fdb
                '''
            }
        }
    }

    post {
        success {
            echo 'Build and deployment completed successfully!'
        }

        failure {
            echo 'Pipeline failed. Check the Jenkins Console Output.'
        }
    }
}
