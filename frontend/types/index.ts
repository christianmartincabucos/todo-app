export interface Task {
    id: string;
    description: string;
    status: string;
    user: User;
}

export interface User {
    id: string;
    name: string;
}

export interface TaskQueryResult {
    tasks: Task[];
}
  
export interface CreateTaskMutationResult {
    createTask: Task;
}
  