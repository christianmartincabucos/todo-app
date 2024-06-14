export interface Task {
    id: string;
    description: string;
    status: string;
}

export interface User {
    id: string;
    name: string;
}

export interface TaskQueryResult {
    me: {
        tasks: Task[];
    }
}
  
export interface CreateTaskMutationResult {
    createTask: Task;
}
  
// export interface LoginMutationResult {
//     login:
// }