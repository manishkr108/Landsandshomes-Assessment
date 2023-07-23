****Run Manish Kumar project Stape by stape ****
1. download the project from my reposetry 
2. composer install
3. Setup .env file
4. php artisan key:generate
5. php artisan migrate
6. php artisan server

**Open the postman**
**store data URL**
1. curl --location --request POST 'http://localhost:8000/api/api-data' \
--form 'name="Manish Kumar"' \
--form 'description="This is test description"' \
--form 'file=@"/C:/Users/MANISH KUMAR/Downloads/WhatsApp Image 2023-07-12 at 3.23.59 PM.jpeg"' \
--form 'type="3"'



**View All Record UR**L
2. curl --location --request GET 'http://localhost:8000/api/api-get-data'


**View Single Record with temp URL**
3. curl --location --request GET 'http://localhost:8000/api/api-data/1'

**Execute the cron job  i am set 1 day for testing**
4. php artisan records:delete
