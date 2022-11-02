@ECHO OFF
SET MYPATH=%~dp0
IF EXIST %MYPATH%bulk_copy_errors.log del /F %MYPATH%bulk_copy_errors.log
mysql_config_editor.exe remove --login-path=wb_migration_source 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
mysql_config_editor.exe set --login-path=wb_migration_source -h127.0.0.1 -P3306 -uroot -p 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
SET command=mysql.exe -h127.0.0.1 -P3306 -uroot -p -s -N information_schema -e "SELECT Variable_Value FROM GLOBAL_VARIABLES WHERE Variable_Name = 'datadir'" 2>> "%MYPATH%bulk_copy_errors.log"
FOR /F "tokens=* USEBACKQ" %%F IN (`%command%`) DO (
    SET DADADIR=%%F
)
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
pushd %DADADIR%
echo [0 %%] Creating directory dump_userlist
mkdir dump_userlist
pushd dump_userlist
copy NUL import_userlist.sql
echo SET SESSION UNIQUE_CHECKS=0; >> import_userlist.sql
echo SET SESSION FOREIGN_KEY_CHECKS=0; >> import_userlist.sql
echo use userlist_test; >> import_userlist.sql
echo [11 %%] Start dumping tables
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users.txt users.csv
del users.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users.csv' INTO TABLE users FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [22 %%] Dumped table users
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users_confirmations --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users_confirmations.txt users_confirmations.csv
del users_confirmations.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users_confirmations.csv' INTO TABLE users_confirmations FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [33 %%] Dumped table users_confirmations
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users_info --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users_info.txt users_info.csv
del users_info.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users_info.csv' INTO TABLE users_info FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [44 %%] Dumped table users_info
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users_remembered --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users_remembered.txt users_remembered.csv
del users_remembered.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users_remembered.csv' INTO TABLE users_remembered FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [55 %%] Dumped table users_remembered
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users_resets --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users_resets.txt users_resets.csv
del users_resets.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users_resets.csv' INTO TABLE users_resets FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [66 %%] Dumped table users_resets
mysqldump.exe --login-path=wb_migration_source -t --tab=. userlist users_throttling --fields-terminated-by=, 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
rename users_throttling.txt users_throttling.csv
del users_throttling.sql
echo LOAD DATA INFILE 'userlist_test_#####_import/users_throttling.csv' INTO TABLE users_throttling FIELDS TERMINATED BY ',' ENCLOSED BY ''; >> import_userlist.sql
echo [77 %%] Dumped table users_throttling
copy NUL import_userlist.cmd
(echo @ECHO OFF) >> import_userlist.cmd
(echo echo Started load data. Please wait.) >> import_userlist.cmd
(echo SET MYPATH=%%~dp0) >> import_userlist.cmd
(echo IF EXIST %%MYPATH%%import_errors.log del /F %%MYPATH%%import_errors.log) >> import_userlist.cmd
(echo SET command=mysql.exe -h127.0.0.1 -P3306 -uroot -p -s -N information_schema -e "SELECT Variable_Value FROM GLOBAL_VARIABLES WHERE Variable_Name = 'datadir'" 2^>^> %%MYPATH%%import_errors.log) >> import_userlist.cmd
(echo FOR /F "tokens=* USEBACKQ" %%%%F IN ^(^`%%command%%^`^) DO ^() >> import_userlist.cmd
(echo     SET DADADIR=%%%%F) >> import_userlist.cmd
(echo ^)) >> import_userlist.cmd
(echo if %%ERRORLEVEL%% GEQ 1 ^() >> import_userlist.cmd
(echo     echo Script has failed. See the log file for details.) >> import_userlist.cmd
(echo     exit /b 1) >> import_userlist.cmd
(echo ^)) >> import_userlist.cmd
(echo pushd %%DADADIR%%) >> import_userlist.cmd
(echo mkdir userlist_test_#####_import) >> import_userlist.cmd
(echo xcopy %%MYPATH%%*.csv userlist_test_#####_import\* 2^>^> %%MYPATH%%import_errors.log) >> import_userlist.cmd
(echo if %%ERRORLEVEL%% GEQ 1 ^() >> import_userlist.cmd
(echo     echo Script has failed. See the log file for details.) >> import_userlist.cmd
(echo     exit /b 1) >> import_userlist.cmd
(echo ^)) >> import_userlist.cmd
(echo xcopy %%MYPATH%%*.sql userlist_test_#####_import\* 2^>^> %%MYPATH%%import_errors.log) >> import_userlist.cmd
(echo if %%ERRORLEVEL%% GEQ 1 ^() >> import_userlist.cmd
(echo     echo Script has failed. See the log file for details.) >> import_userlist.cmd
(echo     exit /b 1) >> import_userlist.cmd
(echo ^)) >> import_userlist.cmd
(echo mysql.exe -h127.0.0.1 -P3306 -uroot -p ^< userlist_test_#####_import\import_userlist.sql 2^>^> %%MYPATH%%import_errors.log) >> import_userlist.cmd
(echo if %%ERRORLEVEL%% GEQ 1 ^() >> import_userlist.cmd
(echo     echo Script has failed. See the log file for details.) >> import_userlist.cmd
(echo     exit /b 1) >> import_userlist.cmd
(echo ^)) >> import_userlist.cmd
(echo rmdir userlist_test_#####_import /s /q) >> import_userlist.cmd
(echo echo Finished load data) >> import_userlist.cmd
(echo popd) >> import_userlist.cmd
(echo pause) >> import_userlist.cmd
echo [88 %%] Generated import script import_userlist.cmd
popd
set TEMPDIR=%DADADIR%dump_userlist
echo Set fso = CreateObject("Scripting.FileSystemObject") > _zipIt.vbs
echo InputFolder = fso.GetAbsolutePathName(WScript.Arguments.Item(0)) >> _zipIt.vbs
echo ZipFile = fso.GetAbsolutePathName(WScript.Arguments.Item(1)) >> _zipIt.vbs
echo CreateObject("Scripting.FileSystemObject").CreateTextFile(ZipFile, True).Write "PK" ^& Chr(5) ^& Chr(6) ^& String(18, vbNullChar) >> _zipIt.vbs
echo Set objShell = CreateObject("Shell.Application") >> _zipIt.vbs
echo Set source = objShell.NameSpace(InputFolder).Items >> _zipIt.vbs
echo objShell.NameSpace(ZipFile).CopyHere(source) >> _zipIt.vbs
echo Do Until objShell.NameSpace( ZipFile ).Items.Count ^= objShell.NameSpace( InputFolder ).Items.Count >> _zipIt.vbs
echo wScript.Sleep 200 >> _zipIt.vbs
echo Loop >> _zipIt.vbs
CScript  _zipIt.vbs  "%TEMPDIR%"  "%DADADIR%dump_userlist.zip" 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
echo [100 %%] Zipped all files to dump_userlist.zip file
xcopy dump_userlist.zip %MYPATH% 2>> "%MYPATH%bulk_copy_errors.log"
if %ERRORLEVEL% GEQ 1 (
    echo Script has failed. See the log file for details.
    exit /b 1
)
del dump_userlist.zip
del _zipIt.vbs
del /F /Q dump_userlist\*.*
rmdir dump_userlist
popd
echo Now you can copy %MYPATH%dump_userlist.zip file to the target server and run the import script.
pause
