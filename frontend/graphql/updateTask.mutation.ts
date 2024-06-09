export const UPDATE_TASK_MUTATION = gql`
  mutation UpdateTask($id: ID!, $status: String!) {
    updateTask(id: $id, status: $status) {
      id
      description
      status
    }
  }
`;