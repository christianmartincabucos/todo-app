export const CREATE_TASK_MUTATION = gql`
  mutation CreateTask($description: String!, $status: String!) {
    createTask(description: $description, status: $status) {
      id
      description
      status
    }
  }
`;

export const DELETE_ALL_TASKS_MUTATION = gql`
  mutation DeleteAllTasks{
    deleteAllTasks
  }
`;

export const DELETE_TASK_MUTATION = gql`
  mutation DeleteTask($id: ID!) {
    deleteTask(id: $id) {
      id
      description
      status
    }
  }
`;

export const UPDATE_TASK_MUTATION = gql`
  mutation UpdateTask($id: ID!, $status: String!) {
    updateTask(id: $id, status: $status) {
      id
      description
      status
    }
  }
`;