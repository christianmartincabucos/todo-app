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