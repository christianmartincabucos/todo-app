export const LOGIN_MUTATION = gql`
mutation Login($email: String!, $password: String!){
    login(email: $email, password: $password){
        user {
            name
            email
        }
        token
    }
}`;