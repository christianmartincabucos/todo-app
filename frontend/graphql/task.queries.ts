import gql from 'graphql-tag';

export const TASKS_QUERY = gql`
  query GetTasks($status: String!) {
      tasks(status: $status) {
          id
          description
          status
          user {
              id
              name
          }
      }
}`

export const GET_MY_TODO_TASKS = gql`
  query GetMyTodoTasks($status: String!) {
    me {
      id
      tasks(status: $status) {
        id
        description
        status
      }
    }
  }
`;

