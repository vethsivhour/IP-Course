import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Task } from './entities/task.entity';
import { CreateTaskDto } from './dto/create-task.dto';
import { Repository } from 'typeorm';
@Injectable()
export class TasksService {
  constructor(
    @InjectRepository(Task)
    private tasksRepo: Repository<Task>,
  ) {}

  // Create a new task using validated DTO
  async create(createTaskDto: CreateTaskDto) {
    const task = this.tasksRepo.create(createTaskDto);
    return await this.tasksRepo.save(task);
  }

  // Find all tasks with related user
  findAll() {
    return this.tasksRepo.find({ relations: ['user'] });
  }

  // Find a single task by ID with proper error handling
  async findOne(id: number) {
    const task = await this.tasksRepo.findOne({ where: { id } });

    if (!task) {
      throw new NotFoundException(`Task with id ${id} not found`);
    }

    return task;
  }
  

  // Update a task safely
  async update(id: number, updateData: Partial<Task>) {
    const result = await this.tasksRepo.update(id, updateData);

    if (result.affected === 0) {
      throw new NotFoundException(`Task with id ${id} not found`);
    }

    return this.findOne(id);
  }

  // Delete a task safely
  async remove(id: number) {
    const result = await this.tasksRepo.delete(id);

    if (result.affected === 0) {
      throw new NotFoundException(`Task with id ${id} not found`);
    }

    return { message: `Task with id ${id} deleted successfully `};
  }
}