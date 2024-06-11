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

export const REGISTRATION_MUTATION = gql`
mutation Register($name: String!, $email: String!, $password: String!, $password_confirmation: String!){
    register(name: $name, email: $email, password: $password, password_confirmation: $password_confirmation) {
        user {
            name
            email
        }
        token
    }
}`;