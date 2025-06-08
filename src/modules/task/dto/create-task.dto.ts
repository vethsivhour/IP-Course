import { IsInt, IsNotEmpty, IsString } from 'class-validator';

export class CreateTaskDto {
  @IsNotEmpty({ message: 'Task name is required' })
  @IsString({ message: 'Task must be string'})
  name: string;

  @IsInt({ message: 'User ID must be an integer' })
  userId: number; 
}