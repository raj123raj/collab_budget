pipeline {
    agent any

    triggers {
        // Poll Git every 5 minutes; or configure a GitHub webhook instead
        pollSCM('H/5 * * * *')
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
                // Assumes PHP is on PATH (e.g. from XAMPP)
                bat '''
                  for /R %%f in (*.php) do php -l "%%f"
                '''
            }
        }

        stage('Deploy to XAMPP') {
            steps {
                // Copy workspace to D:\Xampp1\htdocs\collab-budget
                bat '''
                  set SRC=%WORKSPACE%				  
                  set DEST=D:\\Xampp1\\htdocs\\collab-budget

                  if not exist "%DEST%" (
                    mkdir "%DEST%"
                  )

                  robocopy "%SRC%" "%DEST%" /MIR /XD ".git" ".github" "sql" /XF ".gitignore"
                  if %ERRORLEVEL% GEQ 8 (
                    echo Robocopy failed with exit code %ERRORLEVEL%
                    exit /b %ERRORLEVEL%
                  )
                '''
            }
        }
    }
}
