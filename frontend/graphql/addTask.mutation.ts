export const CREATE_TASK_MUTATION = gql`
  mutation CreateTask($user_id: ID!, $description: String!, $status: String!) {
    createTask(user_id: $user_id, description: $description, status: $status) {
      id
      description
      status
    }
  }
`;