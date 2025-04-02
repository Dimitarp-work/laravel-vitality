<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Simple Diary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title is-2 has-text-centered">My Diary</h1>

            <div class="box">
                <h2 class="subtitle is-4">Today's Entry</h2>
                <h3 class="title is-5">A Sunny Day</h3>
                <p class="subtitle is-6">2024-04-27</p>
                <p>Today was a beautiful sunny day. I went for a walk in the park and enjoyed the fresh air.</p>
            </div>

            <div class="box">
                <h2 class="subtitle is-4">New Entry</h2>
                <form>
                    <div class="field">
                        <label class="label">Title</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="Title">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Date</label>
                        <div class="control">
                            <input class="input" type="date">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Content</label>
                        <div class="control">
                            <textarea class="textarea" placeholder="Content"></textarea>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-primary">Save Entry</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box">
                <h2 class="subtitle is-4">Previous Entries</h2>
                <div class="content">
                    <h3 class="title is-5">A Rainy Evening</h3>
                    <p class="subtitle is-6">2024-04-26</p>
                    <p>Stayed indoors and read a book while it rained outside.</p>
                    <hr>

                    <h3 class="title is-5">A Trip to the Beach</h3>
                    <p class="subtitle is-6">2024-04-25</p>
                    <p>Went to the beach and enjoyed the sunset.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
