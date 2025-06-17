## Introduction

Zameel (زميل) - an Arabic word for "Classmate" - is a mobile app that manages student's content like schedule, books, activities, and exams in an organized way.

> [!NOTE]  
> This is a server side application project, the client side can be found in [here](https://github.com/khateeboveskey/zameel).

## Installation Steps

To set up the project locally, follow these steps:

1.  **Clone the Repository**

    ```sh
    git clone <repository_url>
    cd <project_directory>
    ```

2.  **Install Dependencies**

    ```sh
    composer install
    npm install
    ```

3.  **Set Up Environment**

    -   Copy the `.env.example` file and rename it to `.env`:

    ```sh
    cp .env.example .env
    ```

    -   Update the `.env` file with your database credentials.

4.  **Setup Mail config and Environment keys**

5.  **Setup Broadcasting config and Environment keys**

6.  **Setup OpenAI config and Environment keys**

    ```sh
    OPENAI_API_KEY=
    OPENAI_ORGANIZATION=
    OPENAI_SUMMARY_MODEL="gpt-4.1-nano"
    OPENAI_QUIZ_MODEL="gpt-4.1-nano"
    OPENAI_CHAT_MODEL="gpt-4.1-nano"
    ```

7.  **Setup Pusher Beams config and Environment keys**

    ```sh
    PUSH_NOTIFICATIONS_CONNECTION="pusher_beams"
    PUSHER_BEAMS_INSTANCE_ID=
    PUSHER_BEAMS_KEY=
    ```

8.  **Generate Application Key**

    ```sh
    php artisan key:generate
    ```

9.  **Run Migrations and Seed Database**

    ```sh
    php artisan migrate --seed
    ```

10. **Run the Development Server**
    ```sh
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.
