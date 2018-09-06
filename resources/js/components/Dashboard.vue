<template>
    <div class="card mb-3">
        <div class="card-header">API Endpoints</div>

        <div class="card-body">
            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Method</th>
                    <th>URI</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Create team</td>
                    <td>POST</td>
                    <td><code>/api/teams</code></td>
                </tr>
                <tr>
                    <td>Get team with players</td>
                    <td>GET</td>
                    <td><code>/api/teams/{team}</code></td>
                </tr>
                <tr>
                    <td>Create player</td>
                    <td>POST</td>
                    <td><code>/api/teams/{team}/players</code></td>
                </tr>
                <tr>
                    <td>Update player</td>
                    <td>PUT|PATCH</td>
                    <td><code>/api/teams/{team}/players/{player}</code></td>
                </tr>
                </tbody>
            </table>

            <p>
                Above API routes are protected, to make an API request first create oAuth Personal Token and add to your request header as:
            </p>

            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Authorization</td>
                    <td>Bearer <code>generated_token</code></td>
                </tr>
                </tbody>
            </table>
            <em>
                Note: "Value" field is prefixed with "Bearer ".
            </em>
        </div>
    </div>
</template>


<script>
    export default {
        data(){
            return {
            }
        }
    }
</script>