import endpoints from './endpoints'
let config = {
    endpoints,
    oauth_client: {
        grant_type: 'password',
        client_id: process.env.CLIENT_ID,
        client_secret: process.env.CLIENT_SECRET,
        scope: '*'
    }
}
export default config