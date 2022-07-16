package repository;

import entity.AbstractEntity;

import java.io.Serializable;

public abstract class DataRepository<T extends AbstractEntity, Id extends Serializable> {
    public abstract void create(T abstractEntity);
}
